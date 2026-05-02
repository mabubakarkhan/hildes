@php
    $s = $slide ?? null;
@endphp
<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="bg-slate-900 panel p-5 space-y-4 max-w-3xl">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 text-sm">Pre-title highlight (optional)</label>
            <input name="pre_title_span" value="{{ old('pre_title_span', $s->pre_title_span ?? '') }}" placeholder="e.g. Welcome!">
        </div>
        <div>
            <label class="block mb-1 text-sm">Pre-title rest</label>
            <input name="pre_title_rest" value="{{ old('pre_title_rest', $s->pre_title_rest ?? '') }}" placeholder="e.g. Start Growing Your Business Today">
        </div>
    </div>

    <div>
        <label class="block mb-1 text-sm">Title (use line breaks for multiple lines)</label>
        <textarea name="title" rows="3" placeholder="Headline">{{ old('title', $s->title ?? '') }}</textarea>
    </div>

    <div>
        <label class="block mb-1 text-sm">Description</label>
        <textarea name="disc" rows="4" placeholder="Supporting paragraph">{{ old('disc', $s->disc ?? '') }}</textarea>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 text-sm">Button label</label>
            <input name="button_label" value="{{ old('button_label', $s->button_label ?? '') }}" placeholder="Get Consultant">
        </div>
        <div>
            <label class="block mb-1 text-sm">Link type</label>
            <select name="link_type" id="hero_link_type">
                @php($oldType = old('link_type', $s->link_type ?? 'custom'))
                <option value="custom" @selected($oldType === 'custom')>Custom URL</option>
                <option value="service" @selected($oldType === 'service')>Service page</option>
                <option value="case_study" @selected($oldType === 'case_study')>Case study</option>
            </select>
        </div>
    </div>

    <div id="hero_custom_url_wrap">
        <label class="block mb-1 text-sm">Custom URL</label>
        <input name="button_url" value="{{ old('button_url', $s->button_url ?? '') }}" placeholder="# or /contact or https://example.com">
    </div>

    <div id="hero_service_wrap">
        <label class="block mb-1 text-sm">Select service</label>
        <select name="linked_service_id">
            <option value="">-- Select service --</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}" @selected((string) old('linked_service_id', $s->linked_service_id ?? '') === (string) $service->id)>
                    {{ $service->name }} ({{ $service->slug }})
                </option>
            @endforeach
        </select>
    </div>

    <div id="hero_case_study_wrap">
        <label class="block mb-1 text-sm">Select case study</label>
        <select name="linked_case_study_id">
            <option value="">-- Select case study --</option>
            @foreach($caseStudies as $caseStudy)
                <option value="{{ $caseStudy->id }}" @selected((string) old('linked_case_study_id', $s->linked_case_study_id ?? '') === (string) $caseStudy->id)>
                    {{ $caseStudy->title }} ({{ $caseStudy->slug }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 text-sm">Visual variant</label>
            <select name="style_variant">
                @foreach(['default' => 'Style 1', 'two' => 'Style 2', 'three' => 'Style 3'] as $val => $label)
                    <option value="{{ $val }}" @selected(old('style_variant', $s->style_variant ?? 'default') === $val)>{{ $label }}</option>
                @endforeach
            </select>
            <p class="text-xs text-slate-500 mt-1">Matches the original theme’s three banner colour treatments.</p>
        </div>
        <div>
            <label class="block mb-1 text-sm">Sort order</label>
            <input type="number" name="sort_order" min="0" max="999999" required value="{{ old('sort_order', $s->sort_order ?? 0) }}">
        </div>
    </div>

    <label class="inline-flex items-center gap-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked((string) old('is_active', ($s->is_active ?? true) ? '1' : '0') === '1')>
        <span class="text-sm">Active on homepage</span>
    </label>

    <div>
        <label class="block mb-1 text-sm">Background image @if($s?->background_image) (replace optional) @else (required) @endif</label>
        @if($s?->background_image_url)
            <p class="text-xs text-slate-400 mb-2">Current: <a class="text-orange-300 underline" href="{{ $s->background_image_url }}" target="_blank" rel="noopener">view</a>
                @if(filled($s->background_image_original_name)) ({{ $s->background_image_original_name }}) @endif
            </p>
        @endif
        <input type="file" name="background_image" accept="image/jpeg,image/png,image/webp,image/gif" @if(!$s?->background_image) required @endif>
        <p class="text-xs text-slate-500 mt-2">JPEG, PNG, WebP, or GIF — max 8 MB. Use large images (e.g. 1920px wide) for best quality.</p>
    </div>

    <div>
        <label class="block mb-1 text-sm">Image — small devices (optional)</label>
        @if($s?->small_device_background_image_url)
            <p class="text-xs text-slate-400 mb-2">Current: <a class="text-orange-300 underline" href="{{ $s->small_device_background_image_url }}" target="_blank" rel="noopener">view</a></p>
        @endif
        <input type="file" name="small_device_background_image" accept="image/jpeg,image/png,image/webp,image/gif">
        <p class="text-xs text-slate-500 mt-2">
            If set, phones and small screens use this background instead of the main one, and only the <strong class="text-slate-300">title</strong> and <strong class="text-slate-300">button</strong> are shown (no pre-title, description, or decorative shapes).
        </p>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('admin.home-hero.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
<script>
    (() => {
        const typeSelect = document.getElementById('hero_link_type');
        const customWrap = document.getElementById('hero_custom_url_wrap');
        const serviceWrap = document.getElementById('hero_service_wrap');
        const caseStudyWrap = document.getElementById('hero_case_study_wrap');

        if (!typeSelect || !customWrap || !serviceWrap || !caseStudyWrap) {
            return;
        }

        const syncLinkInputs = () => {
            const t = typeSelect.value;
            customWrap.style.display = t === 'custom' ? '' : 'none';
            serviceWrap.style.display = t === 'service' ? '' : 'none';
            caseStudyWrap.style.display = t === 'case_study' ? '' : 'none';
        };

        typeSelect.addEventListener('change', syncLinkInputs);
        syncLinkInputs();
    })();
</script>
