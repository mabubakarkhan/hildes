<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;
use Throwable;

class WordPressRecentPostsService
{
    public function getRecent(?int $limit = null): Collection
    {
        $limit = $limit ?? (int) config('wordpress.recent_limit', 10);

        if ($limit < 1) {
            return collect();
        }

        try {
            $rows = DB::connection('wordpress')
                ->table('posts as p')
                ->select([
                    'p.ID',
                    'p.post_title',
                    'p.post_name',
                    'p.post_date',
                    'u.display_name as author_name',
                    'att.guid as image_url',
                ])
                ->leftJoin('users as u', 'u.ID', '=', 'p.post_author')
                ->leftJoin('postmeta as pm', function ($join): void {
                    $join->on('pm.post_id', '=', 'p.ID')
                        ->where('pm.meta_key', '=', '_thumbnail_id');
                })
                ->leftJoin('posts as att', function ($join): void {
                    $join->on('att.ID', '=', 'pm.meta_value')
                        ->where('att.post_type', '=', 'attachment');
                })
                ->where('p.post_type', 'post')
                ->where('p.post_status', 'publish')
                ->orderByDesc('p.post_date')
                ->limit($limit)
                ->get();

            return $rows->map(function (stdClass $row, int $index): stdClass {
                $category = $this->firstCategoryName((int) $row->ID);

                $row->category_name = $category ?: 'Blog';
                $row->author_name = filled($row->author_name) ? $row->author_name : 'HilDes';
                $row->url = $this->postUrl((string) $row->post_name);
                $row->fallback_image = 'assets/images/blog/' . str_pad((string) (($index % 3) + 1), 2, '0', STR_PAD_LEFT) . '.webp';

                return $row;
            });
        } catch (Throwable $exception) {
            Log::warning('Unable to load WordPress blog posts.', [
                'message' => $exception->getMessage(),
            ]);

            return collect();
        }
    }

    public function postUrl(string $slug): string
    {
        $slug = trim($slug, '/');

        return rtrim((string) config('wordpress.blog_base_url'), '/') . '/' . $slug;
    }

    private function firstCategoryName(int $postId): ?string
    {
        $name = DB::connection('wordpress')
            ->table('term_relationships as tr')
            ->join('term_taxonomy as tt', 'tt.term_taxonomy_id', '=', 'tr.term_taxonomy_id')
            ->join('terms as t', 't.term_id', '=', 'tt.term_id')
            ->where('tr.object_id', $postId)
            ->where('tt.taxonomy', 'category')
            ->orderBy('t.name')
            ->value('t.name');

        return filled($name) ? (string) $name : null;
    }
}
