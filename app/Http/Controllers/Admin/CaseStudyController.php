<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CaseStudyController extends Controller
{
    public function index()
    {
        $caseStudies = CaseStudy::query()->ordered()->get();

        return view('admin.case-studies.index', compact('caseStudies'));
    }

    public function order()
    {
        $caseStudies = CaseStudy::query()->ordered()->get(['id', 'title', 'slug', 'is_published', 'display_order']);

        return view('admin.case-studies.order', compact('caseStudies'));
    }

    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'order' => ['required', 'array', 'min:1'],
            'order.*' => ['required', 'integer', 'exists:case_studies,id', 'distinct'],
        ]);

        $ids = collect($validated['order'])->map(fn ($id) => (int) $id)->values();
        $allIds = CaseStudy::query()->pluck('id')->map(fn ($id) => (int) $id);
        $missing = $allIds->diff($ids)->values();
        $finalOrder = $ids->merge($missing)->values();

        DB::transaction(function () use ($finalOrder): void {
            foreach ($finalOrder as $index => $id) {
                CaseStudy::query()
                    ->whereKey($id)
                    ->update(['display_order' => $index + 1]);
            }
        });

        return redirect()->route('admin.case-studies.order')->with('success', 'Case studies order updated successfully.');
    }

    public function create()
    {
        return view('admin.case-studies.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request);
        $data = $validated['case_study'];
        $data['slug'] = Str::slug($data['slug']);

        if ($request->hasFile('featured_image')) {
            $upload = $this->storeCaseStudyImage($request->file('featured_image'), $data['slug']);
            $data['featured_image'] = $upload['path'];
            $data['featured_image_original_name'] = $upload['original_name'];
        }

        $caseStudy = CaseStudy::create($data);
        $this->storeSeoMeta($caseStudy, $validated['seo']);

        return redirect()->route('admin.case-studies.index')->with('success', 'Case study created.');
    }

    public function edit(CaseStudy $caseStudy)
    {
        $caseStudy->load('seoMeta');

        return view('admin.case-studies.edit', compact('caseStudy'));
    }

    public function update(Request $request, CaseStudy $caseStudy)
    {
        $validated = $this->validatePayload($request, $caseStudy);
        $data = $validated['case_study'];
        $data['slug'] = Str::slug($data['slug']);

        if ($request->hasFile('featured_image')) {
            if ($caseStudy->featured_image) {
                Storage::disk('public')->delete($caseStudy->featured_image);
            }
            $upload = $this->storeCaseStudyImage($request->file('featured_image'), $data['slug']);
            $data['featured_image'] = $upload['path'];
            $data['featured_image_original_name'] = $upload['original_name'];
        }

        $caseStudy->update($data);
        $this->storeSeoMeta($caseStudy, $validated['seo']);

        return redirect()->route('admin.case-studies.edit', $caseStudy)->with('success', 'Case study updated.');
    }

    public function destroy(CaseStudy $caseStudy)
    {
        if ($caseStudy->featured_image) {
            Storage::disk('public')->delete($caseStudy->featured_image);
        }

        $caseStudy->seoMeta()?->delete();
        $caseStudy->delete();

        return redirect()->route('admin.case-studies.index')->with('success', 'Case study deleted.');
    }

    public function uploadDetailImage(Request $request)
    {
        $validated = $request->validate([
            'upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'slug' => ['nullable', 'string', 'max:255'],
        ]);

        $slug = Str::slug((string) ($validated['slug'] ?? 'case-study'));
        $originalName = pathinfo($request->file('upload')->getClientOriginalName(), PATHINFO_BASENAME);
        $folder = 'case-studies/'.$slug.'/detail';
        $path = $request->file('upload')->storeAs($folder, $originalName, 'public');

        return response()->json(['url' => rtrim(url('/'), '/').'/storage/'.ltrim($path, '/')]);
    }

    private function validatePayload(Request $request, ?CaseStudy $existing = null): array
    {
        $slugRule = Rule::unique('case_studies', 'slug');
        if ($existing) {
            $slugRule->ignore($existing->id);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $slugRule],
            'tagline' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:1200'],
            'detail_content' => ['nullable', 'string'],
            'sections' => ['nullable', 'array'],
            'sections.*' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'featured_image_alt' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
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

        $sections = collect($validated['sections'] ?? [])
            ->map(fn ($value) => trim((string) $value))
            ->filter(fn ($value) => $value !== '')
            ->all();

        return [
            'case_study' => [
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'tagline' => $validated['tagline'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'detail_content' => $validated['detail_content'] ?? null,
                'sections_json' => $sections,
                'featured_image_alt' => $validated['featured_image_alt'] ?? null,
                'is_published' => (bool) ($validated['is_published'] ?? false),
            ],
            'seo' => $seo,
        ];
    }

    private function storeSeoMeta(CaseStudy $caseStudy, array $seo): void
    {
        $caseStudy->seoMeta()->updateOrCreate([], $seo);
    }

    private function storeCaseStudyImage($file, string $slug): array
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_BASENAME);
        $folder = 'case-studies/'.Str::slug($slug);
        $path = $file->storeAs($folder, $originalName, 'public');

        return [
            'path' => $path,
            'original_name' => $originalName,
        ];
    }
}

