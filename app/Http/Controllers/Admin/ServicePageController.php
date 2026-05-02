<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServicePageController extends Controller
{
    public function index()
    {
        $services = ServicePage::query()->ordered()->get();

        return view('admin.services.index', compact('services'));
    }

    public function order()
    {
        $services = ServicePage::query()->ordered()->get(['id', 'name', 'slug', 'is_published', 'display_order']);

        return view('admin.services.order', compact('services'));
    }

    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'order' => ['required', 'array', 'min:1'],
            'order.*' => ['required', 'integer', 'exists:service_pages,id', 'distinct'],
        ]);

        $ids = collect($validated['order'])->map(fn ($id) => (int) $id)->values();
        $allIds = ServicePage::query()->pluck('id')->map(fn ($id) => (int) $id);
        $missing = $allIds->diff($ids)->values();
        $finalOrder = $ids->merge($missing)->values();

        DB::transaction(function () use ($finalOrder): void {
            foreach ($finalOrder as $index => $id) {
                ServicePage::query()
                    ->whereKey($id)
                    ->update(['display_order' => $index + 1]);
            }
        });

        return redirect()->route('admin.services.order')->with('success', 'Service order updated successfully.');
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request);
        $data = $validated['page'];
        $data['slug'] = Str::slug($data['slug']);

        if ($request->hasFile('hero_image')) {
            $heroUpload = $this->storeServiceImage($request->file('hero_image'), $data['slug']);
            $data['hero_image_original_name'] = $heroUpload['original_name'];
            $data['hero_image'] = $heroUpload['path'];
        }

        if ($request->hasFile('general_image')) {
            $generalUpload = $this->storeServiceImage($request->file('general_image'), $data['slug']);
            $data['general_image_original_name'] = $generalUpload['original_name'];
            $data['general_image'] = $generalUpload['path'];
        }

        if ($request->hasFile('body_image')) {
            $bodyUpload = $this->storeServiceImage($request->file('body_image'), $data['slug']);
            $data['body_image_original_name'] = $bodyUpload['original_name'];
            $data['body_image'] = $bodyUpload['path'];
        }

        $service = ServicePage::create($data);
        $this->storeSeoMeta($service, $validated['seo']);

        return redirect()->route('admin.services.index')->with('success', 'Service page created.');
    }

    public function edit(ServicePage $service)
    {
        $service->load('seoMeta');

        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, ServicePage $service)
    {
        $validated = $this->validatePayload($request, $service);
        $data = $validated['page'];
        $data['slug'] = Str::slug($data['slug']);

        if ($request->hasFile('hero_image')) {
            if ($service->hero_image) {
                Storage::disk('public')->delete($service->hero_image);
            }
            $heroUpload = $this->storeServiceImage($request->file('hero_image'), $data['slug']);
            $data['hero_image_original_name'] = $heroUpload['original_name'];
            $data['hero_image'] = $heroUpload['path'];
        }

        if ($request->hasFile('general_image')) {
            if ($service->general_image) {
                Storage::disk('public')->delete($service->general_image);
            }
            $generalUpload = $this->storeServiceImage($request->file('general_image'), $data['slug']);
            $data['general_image_original_name'] = $generalUpload['original_name'];
            $data['general_image'] = $generalUpload['path'];
        }

        if ($request->hasFile('body_image')) {
            if ($service->body_image) {
                Storage::disk('public')->delete($service->body_image);
            }
            $bodyUpload = $this->storeServiceImage($request->file('body_image'), $data['slug']);
            $data['body_image_original_name'] = $bodyUpload['original_name'];
            $data['body_image'] = $bodyUpload['path'];
        }

        $service->update($data);
        $this->storeSeoMeta($service, $validated['seo']);

        return redirect()->route('admin.services.edit', $service)->with('success', 'Service page updated.');
    }

    public function destroy(ServicePage $service)
    {
        if ($service->hero_image) {
            Storage::disk('public')->delete($service->hero_image);
        }
        if ($service->general_image) {
            Storage::disk('public')->delete($service->general_image);
        }
        if ($service->body_image) {
            Storage::disk('public')->delete($service->body_image);
        }
        $service->seoMeta()?->delete();
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service page removed.');
    }

    private function validatePayload(Request $request, ?ServicePage $existing = null): array
    {
        $slugRule = Rule::unique('service_pages', 'slug');
        if ($existing) {
            $slugRule->ignore($existing->id);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $slugRule],
            'is_published' => ['nullable', 'boolean'],
            'hero_headline' => ['nullable', 'string', 'max:255'],
            'hero_content' => ['nullable', 'string'],
            'general_image' => ['nullable', 'image', 'mimes:webp', 'max:4096'],
            'general_image_alt' => ['nullable', 'string', 'max:255'],
            'hero_image' => ['nullable', 'image', 'mimes:webp', 'max:4096'],
            'hero_image_alt' => ['nullable', 'string', 'max:255'],
            'body_heading' => ['nullable', 'string', 'max:255'],
            'body_content' => ['nullable', 'string'],
            'body_image' => ['nullable', 'image', 'mimes:webp', 'max:4096'],
            'body_image_alt' => ['nullable', 'string', 'max:255'],
            'deliverables_text' => ['nullable', 'string'],
            'process_text' => ['nullable', 'string'],
            'global_focus_text' => ['nullable', 'string'],
            'faq_text' => ['nullable', 'string'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.title' => ['nullable', 'string', 'max:255'],
            'faqs.*.detail' => ['nullable', 'string'],
            'seo.seo_enabled' => ['nullable', 'boolean'],
            'seo.is_indexable' => ['nullable', 'boolean'],
            'seo.include_in_sitemap' => ['nullable', 'boolean'],
            'seo.slug' => ['nullable', 'string', 'max:255'],
            'seo.canonical_url' => ['nullable', 'url', 'max:255'],
            'seo.meta_title' => ['nullable', 'string', 'max:255'],
            'seo.meta_description' => ['nullable', 'string'],
            'seo.meta_keywords' => ['nullable', 'string'],
            'seo.focus_keyword' => ['nullable', 'string', 'max:255'],
            'seo.robots_directive' => ['nullable', 'string', 'max:255'],
            'seo.og_title' => ['nullable', 'string', 'max:255'],
            'seo.og_description' => ['nullable', 'string'],
            'seo.og_image' => ['nullable', 'url', 'max:255'],
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

        $page = [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'is_published' => (bool) ($validated['is_published'] ?? false),
            'hero_headline' => $validated['hero_headline'] ?? null,
            'hero_content' => $validated['hero_content'] ?? null,
            'general_image_alt' => $validated['general_image_alt'] ?? null,
            'hero_image_alt' => $validated['hero_image_alt'] ?? null,
            'body_heading' => $validated['body_heading'] ?? null,
            'body_content' => $validated['body_content'] ?? null,
            'body_image_alt' => $validated['body_image_alt'] ?? null,
            'deliverables_text' => $validated['deliverables_text'] ?? null,
            'process_text' => $validated['process_text'] ?? null,
            'global_focus_text' => $validated['global_focus_text'] ?? null,
            'faq_text' => $this->buildLegacyFaqText($faqs),
            'faqs_json' => $faqs,
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

        $seo = $this->syncFaqSchema($seo, $faqs);

        return ['page' => $page, 'seo' => $seo];
    }

    private function storeSeoMeta(ServicePage $service, array $seo): void
    {
        $service->seoMeta()->updateOrCreate([], $seo);
    }

    private function buildLegacyFaqText(array $faqs): string
    {
        if (empty($faqs)) {
            return '';
        }

        return collect($faqs)
            ->map(fn ($item, $idx) => ($idx + 1).'. '.$item['title'].PHP_EOL.$item['detail'])
            ->implode(PHP_EOL.PHP_EOL);
    }

    private function syncFaqSchema(array $seo, array $faqs): array
    {
        $faqNode = [
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqs)->map(fn ($item) => [
                '@type' => 'Question',
                'name' => $item['title'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['detail'],
                ],
            ])->values()->all(),
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
            if (! empty($schema)) {
                $hasType = is_string(Arr::get($schema, '@type'));
                if ($hasType) {
                    $graph[] = $schema;
                }
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

    private function storeServiceImage(UploadedFile $file, string $slug): array
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $folder = 'service-pages/'.Str::slug($slug);
        $path = $file->storeAs($folder, $originalName, 'public');

        return [
            'path' => $path,
            'original_name' => $originalName,
        ];
    }
}
