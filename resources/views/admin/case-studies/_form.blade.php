@php
    $cs = $caseStudy ?? null;
    $seo = $cs?->seoMeta;
    $seoOn = function (string $k, $default = null) use ($seo) {
        return old('seo.' . $k, data_get($seo, $k) ?? $default);
    };
    $sectionsData = old('sections', $cs->sections_json ?? []);
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="bg-slate-900 panel" id="case-study-form">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="flex flex-col lg:flex-row min-h-[520px]">
        <nav id="case-study-tabs-nav" class="lg:w-56 shrink-0 border-b lg:border-b-0 lg:border-r border-slate-800 p-3 space-y-1 flex lg:flex-col flex-row flex-nowrap overflow-x-auto gap-1 lg:gap-0 lg:overflow-visible" aria-label="Case study tabs">
            @foreach([
                'general' => ['label' => 'General', 'icon' => '⚙'],
                'hero' => ['label' => 'Hero', 'icon' => '🚀'],
                'overview' => ['label' => 'Overview', 'icon' => '🏢'],
                'challenge' => ['label' => 'Challenge', 'icon' => '🚨'],
                'approach' => ['label' => 'Approach', 'icon' => '🧠'],
                'infrastructure' => ['label' => 'Infrastructure', 'icon' => '⚙'],
                'stabilization' => ['label' => 'Stabilization', 'icon' => '💻'],
                'devops' => ['label' => 'DevOps', 'icon' => '🔁'],
                'quality' => ['label' => 'Code Quality', 'icon' => '🧪'],
                'process' => ['label' => 'SDLC Process', 'icon' => '📊'],
                'security' => ['label' => 'Security', 'icon' => '🔐'],
                'performance' => ['label' => 'Performance', 'icon' => '⚡'],
                'modernization' => ['label' => 'Modernization', 'icon' => '🧱'],
                'results' => ['label' => 'Results', 'icon' => '📈'],
                'outcome' => ['label' => 'Client Outcome', 'icon' => '💬'],
                'seo' => ['label' => 'SEO & social', 'icon' => '📈'],
            ] as $key => $item)
                <button type="button" data-case-study-tab="{{ $key }}" class="case-study-tab-btn px-3 py-2 rounded-lg text-sm text-left border border-transparent hover:border-orange-500/40 hover:bg-slate-800/80 w-full flex items-center justify-start gap-2">
                    <span aria-hidden="true">{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </button>
            @endforeach
        </nav>

        <div class="flex-1 p-5 min-w-0">
            <div data-case-study-panel="general" class="case-study-tab-panel grid md:grid-cols-2 gap-4">
                <input name="title" required value="{{ old('title', $cs->title ?? '') }}" placeholder="Case study title">
                <input name="slug" required value="{{ old('slug', $cs->slug ?? '') }}" placeholder="Slug (e.g. enterprise-hr-platform-stabilization-and-scaling)">
                <label class="md:col-span-2 inline-flex items-center gap-2">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $cs->is_published ?? false))>
                    Published
                </label>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm">Featured image</label>
                    @if($cs?->featured_image)
                        <p class="text-xs text-slate-400 mb-2">
                            Current:
                            <a class="text-orange-300 underline" href="{{ $cs->featured_image_url }}" target="_blank" rel="noopener">view</a>
                            @if(filled($cs->featured_image_original_name))
                                ({{ $cs->featured_image_original_name }})
                            @endif
                        </p>
                    @endif
                    <input type="file" name="featured_image" accept=".webp,.png,.jpg,.jpeg,.gif,image/webp,image/png,image/jpeg,image/gif">
                    <input name="featured_image_alt" value="{{ old('featured_image_alt', $cs->featured_image_alt ?? '') }}" placeholder="Featured image alt text (for accessibility & SEO)" class="mt-3">
                </div>
            </div>

            <div data-case-study-panel="hero" class="case-study-tab-panel hidden grid md:grid-cols-2 gap-4">
                <input name="tagline" value="{{ old('tagline', $cs->tagline ?? '') }}" placeholder="Tagline" class="md:col-span-2">
                <textarea name="short_description" class="md:col-span-2" placeholder="Short description for homepage listing">{{ old('short_description', $cs->short_description ?? '') }}</textarea>
            </div>

            @foreach([
                'overview' => ['label' => 'Project overview section', 'placeholder' => 'Project overview content'],
                'challenge' => ['label' => 'Challenge section', 'placeholder' => 'Key challenges and issues identified'],
                'approach' => ['label' => 'Approach section', 'placeholder' => 'Recovery and modernization approach'],
                'infrastructure' => ['label' => 'Infrastructure transformation', 'placeholder' => 'Old architecture, new AWS architecture, outcomes'],
                'stabilization' => ['label' => 'Development & codebase stabilization', 'placeholder' => 'Codebase fixes and stabilization work'],
                'devops' => ['label' => 'DevOps & CI/CD implementation', 'placeholder' => 'Git workflow, pipelines, staging, deployment'],
                'quality' => ['label' => 'Code quality & testing', 'placeholder' => 'Code quality tools and standards'],
                'process' => ['label' => 'Process & SDLC implementation', 'placeholder' => 'Agile, sprints, PM tools, SDLC'],
                'security' => ['label' => 'Security & reliability enhancements', 'placeholder' => 'Security controls, monitoring, backup validation'],
                'performance' => ['label' => 'Performance optimization', 'placeholder' => 'Performance improvements and measured impact'],
                'modernization' => ['label' => 'Modernization & future scalability', 'placeholder' => 'Future-ready architecture and scalability'],
                'results' => ['label' => 'Final results', 'placeholder' => 'Final KPI outcomes and achievements'],
                'outcome' => ['label' => 'Client outcome', 'placeholder' => 'Business impact and client-facing outcome'],
            ] as $sectionKey => $sectionMeta)
                <div data-case-study-panel="{{ $sectionKey }}" class="case-study-tab-panel hidden">
                    <label class="block text-sm mb-2">{{ $sectionMeta['label'] }}</label>
                    <textarea name="sections[{{ $sectionKey }}]" class="w-full min-h-[260px] rich-editor" placeholder="{{ $sectionMeta['placeholder'] }}">{{ data_get($sectionsData, $sectionKey, '') }}</textarea>
                </div>
            @endforeach

            <div data-case-study-panel="seo" class="case-study-tab-panel hidden grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2 mt-1">
                    <h3 class="heading-text text-lg mb-1">SEO Section</h3>
                    <p class="text-sm text-slate-400 mb-3">Meta tags, social tags, and schema for this case study page.</p>
                </div>

                <label class="inline-flex items-center gap-2"><input type="checkbox" name="seo[seo_enabled]" value="1" @checked($seoOn('seo_enabled', true))> Enable SEO</label>
                <label class="inline-flex items-center gap-2"><input type="checkbox" name="seo[is_indexable]" value="1" @checked($seoOn('is_indexable', true))> Indexable</label>
                <label class="inline-flex items-center gap-2 md:col-span-2"><input type="checkbox" name="seo[include_in_sitemap]" value="1" @checked($seoOn('include_in_sitemap', true))> Include in sitemap</label>

                <input name="seo[robots_directive]" value="{{ $seoOn('robots_directive', 'index,follow') }}" placeholder="Robots directive">
                <input name="seo[slug]" value="{{ $seoOn('slug') }}" placeholder="SEO slug (optional)">
                <input name="seo[canonical_url]" value="{{ $seoOn('canonical_url') }}" placeholder="Canonical URL">
                <input name="seo[focus_keyword]" value="{{ $seoOn('focus_keyword') }}" placeholder="Focus keyword">
                <input name="seo[meta_title]" value="{{ $seoOn('meta_title') }}" placeholder="Meta title">
                <textarea name="seo[meta_description]" placeholder="Meta description">{{ $seoOn('meta_description') }}</textarea>
                <textarea name="seo[meta_keywords]" placeholder="Meta keywords" class="md:col-span-2">{{ $seoOn('meta_keywords') }}</textarea>

                <input name="seo[og_title]" value="{{ $seoOn('og_title') }}" placeholder="Open Graph title">
                <textarea name="seo[og_description]" placeholder="Open Graph description">{{ $seoOn('og_description') }}</textarea>
                <input name="seo[og_image]" value="{{ $seoOn('og_image') }}" placeholder="Open Graph image URL" class="md:col-span-2">

                <input name="seo[twitter_title]" value="{{ $seoOn('twitter_title') }}" placeholder="Twitter title">
                <textarea name="seo[twitter_description]" placeholder="Twitter description">{{ $seoOn('twitter_description') }}</textarea>
                <input name="seo[twitter_image]" value="{{ $seoOn('twitter_image') }}" placeholder="Twitter image URL" class="md:col-span-2">

                <textarea name="seo[schema_json]" class="md:col-span-2 min-h-[180px]" placeholder='Schema JSON (e.g. @graph with CreativeWork, FAQPage, etc.)'>{{ $seoOn('schema_json') }}</textarea>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 mt-8 pt-5 border-t border-slate-800">
                <button type="button" id="case-study-tab-back" class="btn btn-secondary">Back</button>
                <button type="button" id="case-study-tab-next" class="btn btn-secondary">Next</button>
                <button class="btn btn-primary ml-auto">{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>

<script>
(function () {
    const form = document.getElementById('case-study-form');
    if (!form) return;

    const order = ['general', 'hero', 'overview', 'challenge', 'approach', 'infrastructure', 'stabilization', 'devops', 'quality', 'process', 'security', 'performance', 'modernization', 'results', 'outcome', 'seo'];
    let idx = 0;

    function show(i) {
        idx = Math.max(0, Math.min(order.length - 1, i));
        order.forEach((key, n) => {
            const panel = form.querySelector('[data-case-study-panel="' + key + '"]');
            const tab = form.querySelector('[data-case-study-tab="' + key + '"]');
            if (panel) panel.classList.toggle('hidden', n !== idx);
            if (tab) {
                tab.classList.toggle('border-orange-500/55', n === idx);
                tab.classList.toggle('bg-slate-800', n === idx);
            }
        });
    }

    order.forEach((key, n) => {
        form.querySelector('[data-case-study-tab="' + key + '"]')?.addEventListener('click', () => show(n));
    });
    form.querySelector('#case-study-tab-back')?.addEventListener('click', () => show(idx - 1));
    form.querySelector('#case-study-tab-next')?.addEventListener('click', () => show(idx + 1));

    const richTextAreas = Array.from(form.querySelectorAll('textarea.rich-editor'));
    const csrf = @json(csrf_token());

    class UploadAdapter {
        constructor(loader, slug) {
            this.loader = loader;
            this.slug = slug || 'case-study';
        }

        async upload() {
            const file = await this.loader.file;
            const body = new FormData();
            body.append('upload', file);
            body.append('slug', this.slug);

            const res = await fetch(@json(route('admin.case-studies.upload-detail-image')), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                },
                body,
            });

            if (!res.ok) {
                throw new Error('Image upload failed');
            }

            const data = await res.json();
            if (!data.url) {
                throw new Error('Invalid upload response');
            }

            return { default: data.url };
        }

        abort() {}
    }

    function uploadPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            const slugInput = form.querySelector('input[name="slug"]');
            const slug = slugInput ? slugInput.value : 'case-study';
            return new UploadAdapter(loader, slug);
        };
    }

    const toolbar = [
        'undo', 'redo', '|',
        'heading', '|',
        'bold', 'italic', 'link', '|',
        'bulletedList', 'numberedList', '|',
        'blockQuote', 'insertTable', 'imageUpload',
    ];

    function mountEditors() {
        richTextAreas.forEach((el) => {
            if (!window.ClassicEditor || el.dataset.editorReady === '1') return;
            window.ClassicEditor.create(el, {
                toolbar,
                extraPlugins: [uploadPlugin],
            }).then(() => {
                el.dataset.editorReady = '1';
            }).catch(() => {
                // Keep textarea as fallback.
            });
        });
    }

    if (richTextAreas.length) {
        if (window.ClassicEditor) {
            mountEditors();
        } else {
            const existingLoader = document.querySelector('script[data-ckeditor-loader="1"]');
            if (existingLoader) {
                existingLoader.addEventListener('load', mountEditors, { once: true });
            } else {
                const script = document.createElement('script');
                script.src = 'https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js';
                script.async = true;
                script.dataset.ckeditorLoader = '1';
                script.addEventListener('load', mountEditors, { once: true });
                document.head.appendChild(script);
            }
        }
    }

    show(0);
})();
</script>

