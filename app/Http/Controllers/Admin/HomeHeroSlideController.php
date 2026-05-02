<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\HomeHeroSlide;
use App\Models\ServicePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HomeHeroSlideController extends Controller
{
    public function create()
    {
        return view('admin.home-hero.slides.create', $this->linkOptions());
    }

    public function store(Request $request)
    {
        $validated = $this->slideFields($request, requireImage: true);
        $file = $validated['background_image'];
        $smallFile = $validated['small_device_background_image'] ?? null;
        unset($validated['background_image'], $validated['small_device_background_image']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated = $this->normalizeLinkFields($validated);

        $upload = $this->storeBackground($file);
        $validated['background_image'] = $upload['path'];
        $validated['background_image_original_name'] = $upload['original_name'];

        if ($smallFile) {
            $validated['small_device_background_image'] = $this->storeSmallDeviceBackground($smallFile);
        }

        HomeHeroSlide::query()->create($validated);

        return redirect()->route('admin.home-hero.index')->with('success', 'Hero slide created.');
    }

    public function edit(HomeHeroSlide $slide)
    {
        return view('admin.home-hero.slides.edit', ['slide' => $slide] + $this->linkOptions());
    }

    public function update(Request $request, HomeHeroSlide $slide)
    {
        $validated = $this->slideFields($request, requireImage: false);
        unset($validated['background_image'], $validated['small_device_background_image']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated = $this->normalizeLinkFields($validated);

        if ($request->hasFile('background_image')) {
            if ($slide->background_image) {
                Storage::disk('public')->delete($slide->background_image);
            }
            $upload = $this->storeBackground($request->file('background_image'));
            $validated['background_image'] = $upload['path'];
            $validated['background_image_original_name'] = $upload['original_name'];
        }

        if ($request->hasFile('small_device_background_image')) {
            if ($slide->small_device_background_image) {
                Storage::disk('public')->delete($slide->small_device_background_image);
            }
            $validated['small_device_background_image'] = $this->storeSmallDeviceBackground(
                $request->file('small_device_background_image')
            );
        }

        $slide->update($validated);

        return redirect()->route('admin.home-hero.index')->with('success', 'Hero slide updated.');
    }

    public function destroy(HomeHeroSlide $slide)
    {
        if ($slide->background_image) {
            Storage::disk('public')->delete($slide->background_image);
        }
        if ($slide->small_device_background_image) {
            Storage::disk('public')->delete($slide->small_device_background_image);
        }
        $slide->delete();

        return redirect()->route('admin.home-hero.index')->with('success', 'Hero slide removed.');
    }

    /**
     * @return array{path: string, original_name: string}
     */
    private function storeBackground(\Illuminate\Http\UploadedFile $file): array
    {
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs('home-hero', $originalName, 'public');

        return [
            'path' => $path,
            'original_name' => $originalName,
        ];
    }

    private function storeSmallDeviceBackground(\Illuminate\Http\UploadedFile $file): string
    {
        return $file->store('home-hero', 'public');
    }

    private function slideFields(Request $request, bool $requireImage): array
    {
        return $request->validate([
            'pre_title_span' => ['nullable', 'string', 'max:255'],
            'pre_title_rest' => ['nullable', 'string', 'max:500'],
            'title' => ['nullable', 'string', 'max:2000'],
            'disc' => ['nullable', 'string', 'max:5000'],
            'button_label' => ['nullable', 'string', 'max:255'],
            'link_type' => ['required', Rule::in(['custom', 'service', 'case_study'])],
            'button_url' => ['nullable', 'string', 'max:2000', Rule::requiredIf(fn () => $request->input('link_type') === 'custom')],
            'linked_service_id' => ['nullable', 'integer', Rule::requiredIf(fn () => $request->input('link_type') === 'service'), Rule::exists('service_pages', 'id')],
            'linked_case_study_id' => ['nullable', 'integer', Rule::requiredIf(fn () => $request->input('link_type') === 'case_study'), Rule::exists('case_studies', 'id')],
            'style_variant' => ['required', Rule::in(['default', 'two', 'three'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999999'],
            'background_image' => $requireImage
                ? ['required', 'file', 'image', 'max:8192']
                : ['nullable', 'file', 'image', 'max:8192'],
            'small_device_background_image' => ['nullable', 'file', 'image', 'max:8192'],
        ]);
    }

    private function normalizeLinkFields(array $validated): array
    {
        $validated['button_url'] = isset($validated['button_url']) ? trim((string) $validated['button_url']) : null;

        if ($validated['link_type'] !== 'custom') {
            $validated['button_url'] = null;
        }

        if ($validated['link_type'] !== 'service') {
            $validated['linked_service_id'] = null;
        }

        if ($validated['link_type'] !== 'case_study') {
            $validated['linked_case_study_id'] = null;
        }

        return $validated;
    }

    private function linkOptions(): array
    {
        return [
            'services' => ServicePage::query()
                ->where('is_published', true)
                ->ordered()
                ->get(['id', 'name', 'slug']),
            'caseStudies' => CaseStudy::query()
                ->where('is_published', true)
                ->ordered()
                ->get(['id', 'title', 'slug']),
        ];
    }
}
