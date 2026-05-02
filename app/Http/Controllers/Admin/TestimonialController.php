<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::query()->ordered()->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function order()
    {
        $testimonials = Testimonial::query()->ordered()->get(['id', 'image', 'name', 'display_order', 'is_active']);

        return view('admin.testimonials.order', compact('testimonials'));
    }

    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'order' => ['required', 'array', 'min:1'],
            'order.*' => ['required', 'integer', 'exists:testimonials,id', 'distinct'],
        ]);

        $ids = collect($validated['order'])->map(fn ($id) => (int) $id)->values();
        $allIds = Testimonial::query()->pluck('id')->map(fn ($id) => (int) $id);
        $missing = $allIds->diff($ids)->values();
        $finalOrder = $ids->merge($missing)->values();

        DB::transaction(function () use ($finalOrder): void {
            foreach ($finalOrder as $index => $id) {
                Testimonial::query()
                    ->whereKey($id)
                    ->update(['display_order' => $index + 1]);
            }
        });

        return redirect()->route('admin.testimonials.order')->with('success', 'Testimonials order updated successfully.');
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request, true);
        $upload = $this->storeImage($request->file('image'));
        $validated['image'] = $upload['path'];
        $validated['image_original_name'] = $upload['original_name'];

        Testimonial::query()->create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $this->validatePayload($request, false);

        if ($request->hasFile('image')) {
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $upload = $this->storeImage($request->file('image'));
            $validated['image'] = $upload['path'];
            $validated['image_original_name'] = $upload['original_name'];
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.edit', $testimonial)->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial removed successfully.');
    }

    private function validatePayload(Request $request, bool $imageRequired): array
    {
        $validated = $request->validate([
            'description' => ['nullable', 'string', 'max:5000'],
            'name' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0', 'max:999999'],
            'is_active' => ['nullable', 'boolean'],
            'image' => $imageRequired
                ? ['required', 'image', 'max:4096']
                : ['nullable', 'image', 'max:4096'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['display_order'] = (int) ($validated['display_order'] ?? 0);

        return $validated;
    }

    /**
     * @return array{path: string, original_name: string}
     */
    private function storeImage(\Illuminate\Http\UploadedFile $file): array
    {
        $path = $file->store('testimonials', 'public');

        return [
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
        ];
    }
}
