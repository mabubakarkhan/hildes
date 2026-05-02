<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CmsPageController extends Controller
{
    public function index()
    {
        $pages = CmsPage::query()->orderBy('title')->orderBy('id')->get();

        return view('admin.cms-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.cms-pages.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request);
        $data = $validated['page'];
        $data['slug'] = Str::slug($data['slug']);

        if ($request->hasFile('banner_image')) {
            $upload = $this->storeBanner($request->file('banner_image'), $data['slug']);
            $data['banner_image'] = $upload['path'];
            $data['banner_image_original_name'] = $upload['original_name'];
        }

        $page = CmsPage::query()->create($data);
        $page->seoMeta()->updateOrCreate([], $validated['seo']);

        return redirect()->route('admin.cms-pages.edit', $page)->with('success', 'CMS page created successfully.');
    }

    public function edit(CmsPage $cmsPage)
    {
        $cmsPage->load('seoMeta');

        return view('admin.cms-pages.edit', compact('cmsPage'));
    }

    public function update(Request $request, CmsPage $cmsPage)
    {
        $validated = $this->validatePayload($request, $cmsPage);
        $data = $validated['page'];
        $data['slug'] = Str::slug($data['slug']);

        if ($request->hasFile('banner_image')) {
            if ($cmsPage->banner_image) {
                Storage::disk('public')->delete($cmsPage->banner_image);
            }

            $upload = $this->storeBanner($request->file('banner_image'), $data['slug']);
            $data['banner_image'] = $upload['path'];
            $data['banner_image_original_name'] = $upload['original_name'];
        }

        $cmsPage->update($data);
        $cmsPage->seoMeta()->updateOrCreate([], $validated['seo']);

        return redirect()->route('admin.cms-pages.edit', $cmsPage)->with('success', 'CMS page updated successfully.');
    }

    public function destroy(CmsPage $cmsPage)
    {
        if ($cmsPage->banner_image) {
            Storage::disk('public')->delete($cmsPage->banner_image);
        }

        $cmsPage->seoMeta()?->delete();
        $cmsPage->delete();

        return redirect()->route('admin.cms-pages.index')->with('success', 'CMS page removed successfully.');
    }

    public function uploadDetailImage(Request $request)
    {
        $validated = $request->validate([
            'upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'slug' => ['nullable', 'string', 'max:255'],
        ]);

        $slug = Str::slug((string) ($validated['slug'] ?? 'cms-page'));
        $originalName = pathinfo($request->file('upload')->getClientOriginalName(), PATHINFO_BASENAME);
        $folder = 'cms-pages/'.$slug.'/detail';
        $path = $request->file('upload')->storeAs($folder, $originalName, 'public');

        return response()->json(['url' => rtrim(url('/'), '/').'/storage/'.ltrim($path, '/')]);
    }

    private function validatePayload(Request $request, ?CmsPage $existing = null): array
    {
        $slugRule = Rule::unique('cms_pages', 'slug');
        if ($existing) {
            $slugRule->ignore($existing->id);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $slugRule],
            'detail_content' => ['nullable', 'string'],
            'banner_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'banner_image_alt' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.title' => ['nullable', 'string', 'max:255'],
            'faqs.*.detail' => ['nullable', 'string'],
            'faq_groups' => ['nullable', 'array'],
            'faq_groups.*.category' => ['nullable', 'string', 'max:255'],
            'faq_groups.*.items' => ['nullable', 'array'],
            'faq_groups.*.items.*.title' => ['nullable', 'string', 'max:255'],
            'faq_groups.*.items.*.detail' => ['nullable', 'string'],
            'bump_faq_schema' => ['nullable', 'boolean'],
            'seo.seo_enabled' => ['nullable', 'boolean'],
            'seo.is_indexable' => ['nullable', 'boolean'],
            'seo.include_in_sitemap' => ['nullable', 'boolean'],
            'seo.slug' => ['nullable', 'string', 'max:255'],
            'seo.canonical_url' => ['nullable', 'url', 'max:255'],
            'seo.meta_title' => ['nullable', 'string', 'max:255'],
            'seo.meta_description' => ['nullable', 'string'],
            'seo.meta_keywords' => ['nullable', 'string'],
            'seo.meta_author' => ['nullable', 'string', 'max:255'],
            'seo.meta_viewport' => ['nullable', 'string', 'max:255'],
            'seo.focus_keyword' => ['nullable', 'string', 'max:255'],
            'seo.robots_directive' => ['nullable', 'string', 'max:255'],
            'seo.og_type' => ['nullable', 'string', 'max:100'],
            'seo.og_title' => ['nullable', 'string', 'max:255'],
            'seo.og_description' => ['nullable', 'string'],
            'seo.og_url' => ['nullable', 'url', 'max:255'],
            'seo.og_site_name' => ['nullable', 'string', 'max:255'],
            'seo.og_image' => ['nullable', 'url', 'max:255'],
            'seo.twitter_card' => ['nullable', 'string', 'max:100'],
            'seo.twitter_title' => ['nullable', 'string', 'max:255'],
            'seo.twitter_description' => ['nullable', 'string'],
            'seo.twitter_image' => ['nullable', 'url', 'max:255'],
            'seo.schema_json' => ['nullable', 'string'],
        ]);

        $faqs = collect($validated['faqs'] ?? [])
            ->map(function ($item) {
                $title = trim((string) data_get($item, 'title', ''));
                $detail = trim((string) data_get($item, 'detail', ''));
                return ['title' => $title, 'detail' => $detail];
            })
            ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
            ->values()
            ->all();

        $faqVersion = (int) ($existing?->faq_schema_version ?? 1);
        if ($request->boolean('bump_faq_schema')) {
            $faqVersion++;
        }

        $faqGroups = collect($validated['faq_groups'] ?? [])
            ->map(function ($group) {
                $category = trim((string) data_get($group, 'category', ''));
                $items = collect(data_get($group, 'items', []))
                    ->map(function ($item) {
                        $title = trim((string) data_get($item, 'title', ''));
                        $detail = trim((string) data_get($item, 'detail', ''));
                        return ['title' => $title, 'detail' => $detail];
                    })
                    ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
                    ->values()
                    ->all();

                return [
                    'category' => $category,
                    'items' => $items,
                ];
            })
            ->filter(fn ($group) => $group['category'] !== '' && ! empty($group['items']))
            ->values()
            ->all();

        $page = [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'detail_content' => $validated['detail_content'] ?? null,
            'banner_image_alt' => $validated['banner_image_alt'] ?? null,
            'faqs_json' => $faqs,
            'faq_groups_json' => $faqGroups,
            'faq_schema_version' => max(1, $faqVersion),
            'faq_schema_updated_at' => now(),
            'is_published' => (bool) ($validated['is_published'] ?? false),
        ];

        $seo = $validated['seo'] ?? [];
        foreach (['seo_enabled', 'is_indexable', 'include_in_sitemap'] as $flag) {
            $seo[$flag] = (bool) ($seo[$flag] ?? false);
        }

        if (! empty($seo['schema_json'])) {
            json_decode($seo['schema_json'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                abort(422, 'Schema JSON is invalid. Please provide valid JSON.');
            }
        }

        $seo = $this->syncFaqSchema($seo, $faqs, $faqGroups, $page['faq_schema_version']);

        return ['page' => $page, 'seo' => $seo];
    }

    private function syncFaqSchema(array $seo, array $faqs, array $faqGroups, int $schemaVersion): array
    {
        $groupedFaqNodes = collect($faqGroups)->map(function ($group) {
            $items = collect($group['items'] ?? [])->map(fn ($item) => [
                '@type' => 'Question',
                'name' => $item['title'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['detail'],
                ],
            ])->values()->all();

            return [
                '@type' => 'FAQPage',
                'name' => $group['category'],
                'mainEntity' => $items,
            ];
        })->values();

        $allFaqs = collect($faqs)
            ->concat(
                collect($faqGroups)->flatMap(fn ($group) => $group['items'] ?? [])
            )
            ->filter(fn ($item) => filled($item['title'] ?? null) && filled($item['detail'] ?? null))
            ->unique(fn ($item) => md5($item['title'].'|'.$item['detail']))
            ->values();

        $faqNode = [
            '@type' => 'FAQPage',
            'faq_schema_version' => $schemaVersion,
            'dateModified' => now()->toAtomString(),
            'mainEntity' => $allFaqs->map(fn ($item) => [
                '@type' => 'Question',
                'name' => $item['title'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['detail'],
                ],
            ])->all(),
            'hasPart' => $groupedFaqNodes->all(),
        ];

        $schemaText = trim((string) ($seo['schema_json'] ?? ''));
        $schema = [];
        if ($schemaText !== '') {
            $decoded = json_decode($schemaText, true);
            if (is_array($decoded)) {
                $schema = $decoded;
            }
        }

        $graph = Arr::get($schema, '@graph');
        if (! is_array($graph)) {
            $graph = [];
            if (! empty($schema) && is_string(Arr::get($schema, '@type'))) {
                $graph[] = $schema;
            }
        }

        $faqFound = false;
        foreach ($graph as $index => $node) {
            if (is_array($node) && (($node['@type'] ?? null) === 'FAQPage')) {
                $graph[$index] = $faqNode;
                $faqFound = true;
            }
        }

        if (! $faqFound) {
            $graph[] = $faqNode;
        }

        $seo['schema_json'] = json_encode([
            '@context' => Arr::get($schema, '@context', 'https://schema.org'),
            '@graph' => array_values($graph),
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        return $seo;
    }

    private function storeBanner($file, string $slug): array
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $folder = 'cms-pages/'.Str::slug($slug).'/banner';
        $path = $file->storeAs($folder, $originalName, 'public');

        return [
            'path' => $path,
            'original_name' => $originalName,
        ];
    }
}
