@php($isEdit = isset($testimonial))
@php($recommendedRatio = 'Approx. 545px width (homepage card thumbnail), landscape recommended')

<div class="space-y-5">
    <div>
        <label class="block text-sm mb-2">Image <span class="text-rose-400">*</span></label>
        <input type="file" name="image" accept="image/*"
            class="w-full rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm">
        <p class="text-xs text-slate-400 mt-2">{{ $recommendedRatio }}</p>
        @if($isEdit && $testimonial->image_url)
            <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->image_alt ?: $testimonial->name }}"
                class="mt-3 h-24 rounded-lg border border-white/10 bg-white/5 p-1">
        @endif
    </div>

    <div>
        <label class="block text-sm mb-2">Image Alt</label>
        <input type="text" name="image_alt" value="{{ old('image_alt', $testimonial->image_alt ?? '') }}"
            class="w-full rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm"
            placeholder="Accessible alt text for this image">
    </div>

    <div>
        <label class="block text-sm mb-2">Description</label>
        <textarea name="description" rows="5"
            class="w-full rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm"
            placeholder="Client feedback or testimonial text">{{ old('description', $testimonial->description ?? '') }}</textarea>
    </div>

    <div class="grid md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name', $testimonial->name ?? '') }}"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm mb-2">Designation</label>
            <input type="text" name="designation" value="{{ old('designation', $testimonial->designation ?? '') }}"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm"
                placeholder="e.g. Product Manager">
        </div>
        <div>
            <label class="block text-sm mb-2">Company</label>
            <input type="text" name="company" value="{{ old('company', $testimonial->company ?? '') }}"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm"
                placeholder="e.g. Vertex Agency">
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-2">Display Order</label>
            <input type="number" name="display_order" min="0"
                value="{{ old('display_order', $testimonial->display_order ?? 0) }}"
                class="w-full rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm">
        </div>
        <div class="flex items-end">
            <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active" value="1"
                    {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
                Active
            </label>
        </div>
    </div>
</div>
