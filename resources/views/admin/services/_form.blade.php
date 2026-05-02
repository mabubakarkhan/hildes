@php
    $sp = $service ?? null;
    $seo = $sp?->seoMeta;
    $seoOn = function (string $k, $default = null) use ($seo) {
        return old('seo.' . $k, data_get($seo, $k) ?? $default);
    };
    $faqsData = old('faqs', $sp->faqs_json ?? []);
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="service-page-form" class="bg-slate-900 panel">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="flex flex-col lg:flex-row min-h-[480px]">
        <nav id="service-tabs-nav" class="lg:w-56 shrink-0 border-b lg:border-b-0 lg:border-r border-slate-800 p-3 space-y-1 flex lg:flex-col flex-row flex-nowrap overflow-x-auto gap-1 lg:gap-0 lg:overflow-visible" aria-label="Section tabs">
            @foreach([
                'general' => ['label' => 'General', 'icon' => '⚙'],
                'hero' => ['label' => 'Hero', 'icon' => '🚀'],
                'body' => ['label' => 'Body', 'icon' => '🧩'],
                'deliverables' => ['label' => 'What we deliver', 'icon' => '📦'],
                'process' => ['label' => 'Process', 'icon' => '🛠'],
                'global' => ['label' => 'Global focus', 'icon' => '🌍'],
                'faq' => ['label' => 'FAQ', 'icon' => '❓'],
                'seo' => ['label' => 'SEO & social', 'icon' => '📈'],
            ] as $key => $item)
                <button type="button" data-service-tab="{{ $key }}" class="service-tab-btn px-3 py-2 rounded-lg text-sm text-left border border-transparent hover:border-orange-500/40 hover:bg-slate-800/80 w-full flex items-center justify-start gap-2">
                    <span aria-hidden="true">{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </button>
            @endforeach
        </nav>

        <div class="flex-1 p-5 min-w-0">
            <div data-service-panel="general" class="service-tab-panel grid md:grid-cols-2 gap-4">
                <input name="name" required value="{{ old('name', $sp->name ?? '') }}" placeholder="Internal page name (e.g. SaaS Development)">
                <input name="slug" required value="{{ old('slug', $sp->slug ?? '') }}" placeholder="URL slug (e.g. saas-development)">
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm">General image</label>
                    @if($sp?->general_image)
                        <p class="text-xs text-slate-400 mb-2">Current: <a class="text-orange-300 underline" href="{{ $sp->general_image_url }}" target="_blank" rel="noopener">view</a> @if(filled($sp->general_image_original_name)) ({{ $sp->general_image_original_name }}) @endif</p>
                    @endif
                    <input type="file" name="general_image" accept=".webp,image/webp" id="general_image_input">
                    <input name="general_image_alt" value="{{ old('general_image_alt', $sp->general_image_alt ?? '') }}" placeholder="General image alt text (for accessibility & SEO)" class="mt-3">
                </div>
                <label class="md:col-span-2 inline-flex items-center gap-2">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $sp->is_published ?? false))>
                    Published on site (when frontend is wired)
                </label>
            </div>

            <div data-service-panel="hero" class="service-tab-panel hidden grid md:grid-cols-2 gap-4">
                <input name="hero_headline" value="{{ old('hero_headline', $sp->hero_headline ?? '') }}" placeholder="Hero headline" class="md:col-span-2">
                <textarea name="hero_content" placeholder="Hero content" class="md:col-span-2 rich-editor">{{ old('hero_content', $sp->hero_content ?? '') }}</textarea>
            </div>

            <div data-service-panel="body" class="service-tab-panel hidden grid md:grid-cols-2 gap-4">
                <input name="body_heading" value="{{ old('body_heading', $sp->body_heading ?? '') }}" placeholder="Body section heading" class="md:col-span-2">
                <textarea name="body_content" placeholder="Body section content" class="md:col-span-2 rich-editor">{{ old('body_content', $sp->body_content ?? '') }}</textarea>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm">Hero image</label>
                    @if($sp?->hero_image)
                        <p class="text-xs text-slate-400 mb-2">Current: <a class="text-orange-300 underline" href="{{ $sp->hero_image_url }}" target="_blank" rel="noopener">view</a> @if(filled($sp->hero_image_original_name)) ({{ $sp->hero_image_original_name }}) @endif</p>
                    @endif
                    <input type="file" name="hero_image" accept=".webp,image/webp" id="hero_image_input">
                    <input name="hero_image_alt" value="{{ old('hero_image_alt', $sp->hero_image_alt ?? '') }}" placeholder="Hero image alt text (for accessibility & SEO)" class="mt-3">
                </div>
            </div>

            <div data-service-panel="deliverables" class="service-tab-panel hidden">
                <textarea name="deliverables_text" class="w-full min-h-[220px] rich-editor" placeholder="One deliverable per line">{{ old('deliverables_text', $sp->deliverables_text ?? '') }}</textarea>
            </div>

            <div data-service-panel="process" class="service-tab-panel hidden">
                <textarea name="process_text" class="w-full min-h-[220px] rich-editor" placeholder="Numbered steps or process copy (one block)">{{ old('process_text', $sp->process_text ?? '') }}</textarea>
            </div>

            <div data-service-panel="global" class="service-tab-panel hidden">
                <textarea name="global_focus_text" class="w-full min-h-[220px] rich-editor" placeholder="Regions, positioning, global SaaS focus copy">{{ old('global_focus_text', $sp->global_focus_text ?? '') }}</textarea>
                <div class="md:col-span-2 mt-4">
                    <label class="block mb-1 text-sm">Body image</label>
                    @if($sp?->body_image)
                        <p class="text-xs text-slate-400 mb-2">Current: <a class="text-orange-300 underline" href="{{ $sp->body_image_url }}" target="_blank" rel="noopener">view</a> @if(filled($sp->body_image_original_name)) ({{ $sp->body_image_original_name }}) @endif</p>
                    @endif
                    <input type="file" name="body_image" accept=".webp,image/webp" id="body_image_input">
                    <input name="body_image_alt" value="{{ old('body_image_alt', $sp->body_image_alt ?? '') }}" placeholder="Body image alt text (for accessibility & SEO)" class="mt-3">
                </div>
            </div>

            <div data-service-panel="faq" class="service-tab-panel hidden">
                <div class="flex flex-wrap gap-2 items-center justify-between mb-4">
                    <h3 class="heading-text text-lg">FAQs</h3>
                    <div class="flex gap-2">
                        <button type="button" class="btn btn-secondary" id="add-faq-row">Add FAQ</button>
                        <button type="button" class="btn btn-secondary" id="sync-faq-to-schema">Update Schema FAQs</button>
                    </div>
                </div>
                <div id="faq-rows" class="space-y-4">
                    @forelse($faqsData as $idx => $faq)
                        <div class="faq-row border border-slate-800 rounded-lg p-3 bg-slate-800/40">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-slate-300">FAQ {{ $idx + 1 }}</p>
                                <button type="button" class="btn btn-secondary remove-faq-row">Remove</button>
                            </div>
                            <input name="faqs[{{ $idx }}][title]" value="{{ data_get($faq, 'title', '') }}" placeholder="FAQ title / question" class="mb-2">
                            <textarea name="faqs[{{ $idx }}][detail]" placeholder="FAQ detail / answer" class="rich-editor">{{ data_get($faq, 'detail', '') }}</textarea>
                        </div>
                    @empty
                        <div class="faq-row border border-slate-800 rounded-lg p-3 bg-slate-800/40">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-slate-300">FAQ 1</p>
                                <button type="button" class="btn btn-secondary remove-faq-row">Remove</button>
                            </div>
                            <input name="faqs[0][title]" placeholder="FAQ title / question" class="mb-2">
                            <textarea name="faqs[0][detail]" placeholder="FAQ detail / answer" class="rich-editor"></textarea>
                        </div>
                    @endforelse
                </div>
            </div>

            <div data-service-panel="seo" class="service-tab-panel hidden grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2 mt-1">
                    <h3 class="heading-text text-lg mb-1">SEO &amp; social</h3>
                    <p class="text-sm text-slate-400 mb-3">Same pattern as jobs: meta, Open Graph, Twitter, and JSON-LD in schema field.</p>
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

                <textarea name="seo[schema_json]" id="schema_json_field" class="md:col-span-2 min-h-[140px]" placeholder='Schema JSON (e.g. @graph with Service + FAQPage)'>{{ $seoOn('schema_json') }}</textarea>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 mt-8 pt-5 border-t border-slate-800">
                <button type="button" id="service-tab-back" class="btn btn-secondary">Back</button>
                <button type="button" id="service-tab-next" class="btn btn-secondary">Next</button>
                <button type="submit" class="btn btn-primary ml-auto">{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>

<style>
    #service-page-form textarea {
        padding: 0.95rem 0.9rem !important;
    }

    #service-page-form .ck-editor__editable_inline {
        padding: 0.95rem 0.9rem !important;
    }
</style>

<div id="service-toast" class="fixed right-5 bottom-5 z-[90] hidden rounded-lg border border-orange-500/50 bg-slate-900 px-4 py-2 text-sm text-orange-200 shadow-lg"></div>

<script>
(function () {
    const order = ['general', 'hero', 'body', 'deliverables', 'process', 'global', 'faq', 'seo'];
    let idx = 0;
    const editors = new WeakMap();

    const ckToolbar = [
        'undo', 'redo', '|',
        'heading', '|',
        'bold', 'italic', 'link', '|',
        'bulletedList', 'numberedList', '|',
        'blockQuote',
    ];

    function initOneRichEditor(el) {
        if (!el || editors.has(el) || !window.ClassicEditor) return;
        window.ClassicEditor.create(el, { toolbar: ckToolbar }).then((editor) => {
            editors.set(el, editor);
        }).catch(() => {
            // Fail silently and keep plain textarea usable.
        });
    }

    function initRichEditors() {
        const targets = Array.from(document.querySelectorAll('#service-page-form textarea.rich-editor'));
        if (!targets.length) return;

        const mount = () => targets.forEach((el) => initOneRichEditor(el));

        if (window.ClassicEditor) return mount();

        const existingLoader = document.querySelector('script[data-ckeditor-loader="1"]');
        if (existingLoader) {
            existingLoader.addEventListener('load', mount, { once: true });
            return;
        }

        const script = document.createElement('script');
        script.src = 'https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js';
        script.async = true;
        script.dataset.ckeditorLoader = '1';
        script.addEventListener('load', mount, { once: true });
        document.head.appendChild(script);
    }

    function reindexFaqRows() {
        const rows = Array.from(document.querySelectorAll('#faq-rows .faq-row'));
        rows.forEach((row, index) => {
            const title = row.querySelector('input[name*="[title]"]');
            const detail = row.querySelector('textarea[name*="[detail]"]');
            const label = row.querySelector('p');
            if (label) label.textContent = 'FAQ ' + (index + 1);
            if (title) title.name = `faqs[${index}][title]`;
            if (detail) detail.name = `faqs[${index}][detail]`;
        });
    }

    function getEditorData(textarea) {
        const editor = editors.get(textarea);
        if (!editor) return textarea.value || '';
        return editor.getData() || '';
    }

    function extractFaqMainEntity() {
        return Array.from(document.querySelectorAll('#faq-rows .faq-row')).map((row) => {
            const titleInput = row.querySelector('input[name*="[title]"]');
            const detailArea = row.querySelector('textarea[name*="[detail]"]');
            const title = (titleInput?.value || '').trim();
            const detail = getEditorData(detailArea).trim();
            if (!title || !detail) return null;
            return {
                '@type': 'Question',
                name: title,
                acceptedAnswer: {
                    '@type': 'Answer',
                    text: detail,
                },
            };
        }).filter(Boolean);
    }

    function updateSchemaFaqs() {
        const schemaField = document.getElementById('schema_json_field');
        if (!schemaField) return;

        const faqMainEntity = extractFaqMainEntity();
        let schemaObj = {};
        try {
            schemaObj = schemaField.value?.trim() ? JSON.parse(schemaField.value) : {};
        } catch (err) {
            throw new Error('Schema JSON is invalid. Please fix it first.');
        }

        let graph = Array.isArray(schemaObj['@graph']) ? [...schemaObj['@graph']] : [];
        if (!graph.length && schemaObj['@type']) graph.push(schemaObj);

        const faqNode = { '@type': 'FAQPage', mainEntity: faqMainEntity };
        const faqIndex = graph.findIndex((node) => node && node['@type'] === 'FAQPage');
        if (faqIndex >= 0) graph[faqIndex] = faqNode;
        else graph.push(faqNode);

        const nextSchema = {
            ['@' + 'context']: schemaObj['@' + 'context'] || 'https://schema.org',
            '@graph': graph,
        };
        schemaField.value = JSON.stringify(nextSchema, null, 2);
        return faqMainEntity.length;
    }

    function showToast(message, type = 'success') {
        const toast = document.getElementById('service-toast');
        if (!toast) return;
        toast.textContent = message;
        toast.classList.remove('hidden', 'border-red-500/50', 'text-red-200', 'border-orange-500/50', 'text-orange-200');
        if (type === 'error') {
            toast.classList.add('border-red-500/50', 'text-red-200');
        } else {
            toast.classList.add('border-orange-500/50', 'text-orange-200');
        }
        clearTimeout(showToast._t);
        showToast._t = setTimeout(() => toast.classList.add('hidden'), 2600);
    }

    function attachFaqActions() {
        document.getElementById('add-faq-row')?.addEventListener('click', () => {
            const rowsWrap = document.getElementById('faq-rows');
            if (!rowsWrap) return;
            const row = document.createElement('div');
            row.className = 'faq-row border border-slate-800 rounded-lg p-3 bg-slate-800/40';
            row.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <p class="text-sm text-slate-300">FAQ</p>
                    <button type="button" class="btn btn-secondary remove-faq-row">Remove</button>
                </div>
                <input placeholder="FAQ title / question" class="mb-2">
                <textarea placeholder="FAQ detail / answer" class="rich-editor"></textarea>
            `;
            rowsWrap.appendChild(row);
            reindexFaqRows();
            initOneRichEditor(row.querySelector('textarea.rich-editor'));
        });

        document.getElementById('faq-rows')?.addEventListener('click', (event) => {
            const btn = event.target.closest('.remove-faq-row');
            if (!btn) return;
            const rowsWrap = document.getElementById('faq-rows');
            if (!rowsWrap) return;
            const row = btn.closest('.faq-row');
            if (!row) return;
            row.remove();
            if (!rowsWrap.querySelector('.faq-row')) {
                document.getElementById('add-faq-row')?.click();
            } else {
                reindexFaqRows();
            }
        });

        document.getElementById('sync-faq-to-schema')?.addEventListener('click', (event) => {
            const btn = event.currentTarget;
            if (!(btn instanceof HTMLButtonElement)) return;
            const original = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'Updating...';
            try {
                const count = updateSchemaFaqs();
                showToast(`Schema updated with ${count} FAQ${count === 1 ? '' : 's'}.`);
            } catch (err) {
                showToast(err?.message || 'Failed to update schema FAQs.', 'error');
            } finally {
                setTimeout(() => {
                    btn.disabled = false;
                    btn.textContent = original;
                }, 500);
            }
        });
    }

    function show(i) {
        idx = Math.max(0, Math.min(order.length - 1, i));
        order.forEach((key, n) => {
            const p = document.querySelector('[data-service-panel="' + key + '"]');
            const b = document.querySelector('[data-service-tab="' + key + '"]');
            if (p) p.classList.toggle('hidden', n !== idx);
            if (b) {
                b.classList.toggle('border-orange-500/55', n === idx);
                b.classList.toggle('bg-slate-800', n === idx);
            }
        });
    }

    order.forEach((key, n) => {
        const b = document.querySelector('[data-service-tab="' + key + '"]');
        if (b) b.addEventListener('click', () => show(n));
    });

    document.getElementById('service-tab-back')?.addEventListener('click', () => show(idx - 1));
    document.getElementById('service-tab-next')?.addEventListener('click', () => show(idx + 1));

    attachFaqActions();
    initRichEditors();
    reindexFaqRows();
    show(0);
})();
</script>
