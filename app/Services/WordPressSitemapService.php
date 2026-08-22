<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;
use Throwable;

class WordPressSitemapService
{
    public function getEntries(): Collection
    {
        try {
            return collect()
                ->concat($this->blogIndexEntry())
                ->concat($this->postEntries())
                ->concat($this->safeTaxonomyEntries('category', 'category'));
        } catch (Throwable $exception) {
            Log::warning('Unable to load WordPress sitemap entries.', [
                'message' => $exception->getMessage(),
            ]);

            return collect();
        }
    }

    private function blogIndexEntry(): Collection
    {
        return collect([[
            'loc' => $this->blogUrl(''),
            'lastmod' => now()->toAtomString(),
            'priority' => 0.8,
        ]]);
    }

    private function postEntries(): Collection
    {
        return DB::connection('wordpress')
            ->table('posts')
            ->select(['post_name', 'post_modified', 'post_date'])
            ->where('post_type', 'post')
            ->where('post_status', 'publish')
            ->orderByDesc('post_modified')
            ->get()
            ->map(fn (stdClass $row): array => [
                'loc' => $this->blogUrl((string) $row->post_name),
                'lastmod' => $this->formatDate($row->post_modified ?: $row->post_date),
                'priority' => 0.8,
            ]);
    }

    private function safeTaxonomyEntries(string $taxonomy, string $pathSegment): Collection
    {
        try {
            return $this->taxonomyEntries($taxonomy, $pathSegment);
        } catch (Throwable $exception) {
            Log::warning('Unable to load WordPress taxonomy sitemap entries.', [
                'taxonomy' => $taxonomy,
                'message' => $exception->getMessage(),
            ]);

            return collect();
        }
    }

    private function taxonomyEntries(string $taxonomy, string $pathSegment): Collection
    {
        $postAlias = DB::connection('wordpress')->getTablePrefix().'p';

        return DB::connection('wordpress')
            ->table('terms as t')
            ->select([
                't.slug',
                DB::raw("MAX({$postAlias}.post_modified) as last_modified"),
            ])
            ->join('term_taxonomy as tt', 'tt.term_id', '=', 't.term_id')
            ->leftJoin('term_relationships as tr', 'tr.term_taxonomy_id', '=', 'tt.term_taxonomy_id')
            ->leftJoin('posts as p', function ($join): void {
                $join->on('p.ID', '=', 'tr.object_id')
                    ->where('p.post_type', '=', 'post')
                    ->where('p.post_status', '=', 'publish');
            })
            ->where('tt.taxonomy', $taxonomy)
            ->when($taxonomy === 'category', fn ($query) => $query->where('t.slug', '!=', 'uncategorized'))
            ->groupBy('t.term_id', 't.slug')
            ->orderBy('t.slug')
            ->get()
            ->map(fn (stdClass $row): array => [
                'loc' => $this->blogUrl($pathSegment.'/'.(string) $row->slug),
                'lastmod' => $this->formatDate($row->last_modified),
                'priority' => 0.64,
            ]);
    }

    private function blogUrl(string $path): string
    {
        $base = rtrim((string) config('wordpress.blog_base_url'), '/');
        $path = trim($path, '/');

        if ($path === '') {
            return $base.'/';
        }

        return $base.'/'.$path.'/';
    }

    private function formatDate(mixed $value): string
    {
        if (blank($value)) {
            return now()->toAtomString();
        }

        return \Illuminate\Support\Carbon::parse($value)->toAtomString();
    }
}
