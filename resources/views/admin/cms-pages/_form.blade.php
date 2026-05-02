@php
    $page = $cmsPage ?? null;
    $seo = $page?->seoMeta;
    $seoOn = function (string $k, $default = null) use ($seo) {
        return old('seo.' . $k, data_get($seo, $k) ?? $default);
    };
    $faqsData = old('faqs', $page->faqs_json ?? []);
    $faqGroupsData = old('faq_groups', $page->faq_groups_json ?? []);
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="cms-page-form" class="bg-slate-900 panel">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <input type="hidden" name="bump_faq_schema" id="bump_faq_schema" value="0">

    <div class="flex flex-col lg:flex-row min-h-[480px]">
        <nav id="cms-tabs-nav" class="lg:w-56 shrink-0 border-b lg:border-b-0 lg:border-r border-slate-800 p-3 space-y-1 flex lg:flex-col flex-row flex-nowrap overflow-x-auto gap-1 lg:gap-0 lg:overflow-visible" aria-label="Section tabs">
            @foreach([
                'general' => ['label' => 'General', 'icon' => '⚙'],
                'detail' => ['label' => 'Detail', 'icon' => '📝'],
                'grouped-faq' => ['label' => 'Grouped FAQs', 'icon' => '🗂️'],
                'faq' => ['label' => 'FAQs', 'icon' => '❓'],
                'seo' => ['label' => 'SEO & social', 'icon' => '📈'],
            ] as $key => $item)
                <button type="button" data-cms-tab="{{ $key }}" class="cms-tab-btn px-3 py-2 rounded-lg text-sm text-left border border-transparent hover:border-orange-500/40 hover:bg-slate-800/80 w-full flex items-center justify-start gap-2">
                    <span aria-hidden="true">{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </button>
            @endforeach
        </nav>

        <div class="flex-1 p-5 min-w-0">
            <div data-cms-panel="general" class="cms-tab-panel grid md:grid-cols-2 gap-4">
                <input name="title" required value="{{ old('title', $page->title ?? '') }}" placeholder="Page title (e.g. Privacy Policy)">
                <input name="slug" required value="{{ old('slug', $page->slug ?? '') }}" placeholder="URL slug (e.g. privacy-policy)">
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm">Optional banner image</label>
                    @if($page?->banner_image)
                        <p class="text-xs text-slate-400 mb-2">
                            Current: <a class="text-orange-300 underline" href="{{ $page->banner_image_url }}" target="_blank" rel="noopener">view</a>
                            @if(filled($page->banner_image_original_name)) ({{ $page->banner_image_original_name }}) @endif
                        </p>
                    @endif
                    <input type="file" name="banner_image" accept=".webp,.png,.jpg,.jpeg,.gif,image/webp,image/png,image/jpeg,image/gif">
                    <input name="banner_image_alt" value="{{ old('banner_image_alt', $page->banner_image_alt ?? '') }}" placeholder="Banner image alt text" class="mt-3">
                </div>
                <label class="md:col-span-2 inline-flex items-center gap-2">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page->is_published ?? true))>
                    Published on site
                </label>
            </div>

            <div data-cms-panel="detail" class="cms-tab-panel hidden">
                <label class="block mb-2 text-sm">Page detail content (Rich editor)</label>
                <textarea name="detail_content" class="w-full min-h-[360px] rich-editor" placeholder="Add full page content here...">{{ old('detail_content', $page->detail_content ?? '') }}</textarea>
            </div>

            <div data-cms-panel="grouped-faq" class="cms-tab-panel hidden">
                <div class="flex flex-wrap gap-2 items-center justify-between mb-4">
                    <div>
                        <h3 class="heading-text text-lg">Grouped FAQs (FAQ page only)</h3>
                        <p class="text-xs text-slate-400 mt-1">Create category-wise FAQ groups for the dedicated FAQs page.</p>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="btn btn-secondary" id="add-faq-group">Add Category Group</button>
                        <button type="button" class="btn btn-secondary" id="sync-grouped-faq-to-schema">Update FAQ Schema Version</button>
                    </div>
                </div>
                <div id="faq-group-rows" class="space-y-4">
                    @forelse($faqGroupsData as $gIdx => $group)
                        <div class="faq-group-row border border-slate-800 rounded-lg p-3 bg-slate-800/40" data-group-index="{{ $gIdx }}">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-slate-300">Group {{ $gIdx + 1 }}</p>
                                <button type="button" class="btn btn-secondary remove-faq-group">Remove Group</button>
                            </div>
                            <input name="faq_groups[{{ $gIdx }}][category]" value="{{ data_get($group, 'category', '') }}" placeholder="Category title (e.g. General Questions)" class="mb-3">
                            <div class="group-faq-items space-y-2">
                                @foreach((data_get($group, 'items', []) ?: []) as $iIdx => $item)
                                    <div class="group-faq-item border border-slate-700 rounded-lg p-2 bg-slate-900/40">
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="text-xs text-slate-400">Item {{ $iIdx + 1 }}</p>
                                            <button type="button" class="btn btn-secondary remove-group-faq-item">Remove Item</button>
                                        </div>
                                        <input name="faq_groups[{{ $gIdx }}][items][{{ $iIdx }}][title]" value="{{ data_get($item, 'title', '') }}" placeholder="Question" class="mb-2">
                                        <textarea name="faq_groups[{{ $gIdx }}][items][{{ $iIdx }}][detail]" placeholder="Answer" class="rich-editor">{{ data_get($item, 'detail', '') }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary mt-3 add-group-faq-item">Add Group FAQ</button>
                        </div>
                    @empty
                        <div class="faq-group-row border border-slate-800 rounded-lg p-3 bg-slate-800/40" data-group-index="0">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-slate-300">Group 1</p>
                                <button type="button" class="btn btn-secondary remove-faq-group">Remove Group</button>
                            </div>
                            <input name="faq_groups[0][category]" placeholder="Category title (e.g. General Questions)" class="mb-3">
                            <div class="group-faq-items space-y-2">
                                <div class="group-faq-item border border-slate-700 rounded-lg p-2 bg-slate-900/40">
                                    <div class="flex justify-between items-center mb-2">
                                        <p class="text-xs text-slate-400">Item 1</p>
                                        <button type="button" class="btn btn-secondary remove-group-faq-item">Remove Item</button>
                                    </div>
                                    <input name="faq_groups[0][items][0][title]" placeholder="Question" class="mb-2">
                                    <textarea name="faq_groups[0][items][0][detail]" placeholder="Answer" class="rich-editor"></textarea>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary mt-3 add-group-faq-item">Add Group FAQ</button>
                        </div>
                    @endforelse
                </div>
            </div>

            <div data-cms-panel="faq" class="cms-tab-panel hidden">
                <div class="flex flex-wrap gap-2 items-center justify-between mb-4">
                    <div>
                        <h3 class="heading-text text-lg">FAQs</h3>
                        <p class="text-xs text-slate-400 mt-1">
                            Current FAQ schema version: <strong>{{ $page->faq_schema_version ?? 1 }}</strong>
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="btn btn-secondary" id="add-faq-row">Add FAQ</button>
                        <button type="button" class="btn btn-secondary" id="sync-faq-to-schema">Update FAQ Schema Version</button>
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

            <div data-cms-panel="seo" class="cms-tab-panel hidden grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2 mt-1">
                    <h3 class="heading-text text-lg mb-1">SEO Section</h3>
                    <p class="text-sm text-slate-400 mb-3">Meta tags, OpenGraph, Twitter, canonical, robots and schema JSON.</p>
                </div>

                <label class="inline-flex items-center gap-2"><input type="checkbox" name="seo[seo_enabled]" value="1" @checked($seoOn('seo_enabled', true))> Enable SEO</label>
                <label class="inline-flex items-center gap-2"><input type="checkbox" name="seo[is_indexable]" value="1" @checked($seoOn('is_indexable', true))> Indexable</label>
                <label class="inline-flex items-center gap-2 md:col-span-2"><input type="checkbox" name="seo[include_in_sitemap]" value="1" @checked($seoOn('include_in_sitemap', true))> Include in sitemap</label>

                <input name="seo[meta_title]" value="{{ $seoOn('meta_title') }}" placeholder="Meta title">
                <input name="seo[meta_author]" value="{{ $seoOn('meta_author', 'HilDes') }}" placeholder="Meta author">
                <textarea name="seo[meta_description]" placeholder="Meta description">{{ $seoOn('meta_description') }}</textarea>
                <textarea name="seo[meta_keywords]" placeholder="Meta keywords">{{ $seoOn('meta_keywords') }}</textarea>
                <input name="seo[meta_viewport]" value="{{ $seoOn('meta_viewport', 'width=device-width, initial-scale=1.0') }}" placeholder="Meta viewport">
                <input name="seo[focus_keyword]" value="{{ $seoOn('focus_keyword') }}" placeholder="Focus keyword">
                <input name="seo[robots_directive]" value="{{ $seoOn('robots_directive', 'index, follow') }}" placeholder="Robots directive">
                <input name="seo[canonical_url]" value="{{ $seoOn('canonical_url') }}" placeholder="Canonical URL">
                <input name="seo[slug]" value="{{ $seoOn('slug') }}" placeholder="SEO slug (optional)">

                <input name="seo[og_type]" value="{{ $seoOn('og_type', 'website') }}" placeholder="OG type">
                <input name="seo[og_title]" value="{{ $seoOn('og_title') }}" placeholder="Open Graph title">
                <textarea name="seo[og_description]" placeholder="Open Graph description">{{ $seoOn('og_description') }}</textarea>
                <input name="seo[og_url]" value="{{ $seoOn('og_url') }}" placeholder="Open Graph URL">
                <input name="seo[og_site_name]" value="{{ $seoOn('og_site_name', 'HilDes') }}" placeholder="Open Graph site name">
                <input name="seo[og_image]" value="{{ $seoOn('og_image') }}" placeholder="Open Graph image URL">

                <input name="seo[twitter_card]" value="{{ $seoOn('twitter_card', 'summary_large_image') }}" placeholder="Twitter card">
                <input name="seo[twitter_title]" value="{{ $seoOn('twitter_title') }}" placeholder="Twitter title">
                <textarea name="seo[twitter_description]" placeholder="Twitter description">{{ $seoOn('twitter_description') }}</textarea>
                <input name="seo[twitter_image]" value="{{ $seoOn('twitter_image') }}" placeholder="Twitter image URL">

                <textarea name="seo[schema_json]" id="schema_json_field" class="md:col-span-2 min-h-[170px]" placeholder='Schema JSON (WebPage + FAQPage etc.)'>{{ $seoOn('schema_json') }}</textarea>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 mt-8 pt-5 border-t border-slate-800">
                <button type="button" id="cms-tab-back" class="btn btn-secondary">Back</button>
                <button type="button" id="cms-tab-next" class="btn btn-secondary">Next</button>
                <button type="submit" class="btn btn-primary ml-auto">{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>

<script>
(function () {
    const form = document.getElementById('cms-page-form');
    if (!form) return;

    const order = ['general', 'detail', 'grouped-faq', 'faq', 'seo'];
    let idx = 0;
    const editors = new WeakMap();

    class UploadAdapter {
        constructor(loader, slug) {
            this.loader = loader;
            this.slug = slug || 'cms-page';
        }

        async upload() {
            const file = await this.loader.file;
            const body = new FormData();
            body.append('upload', file);
            body.append('slug', this.slug);

            const res = await fetch(@json(route('admin.cms-pages.upload-detail-image')), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': @json(csrf_token()) },
                body,
            });

            if (!res.ok) throw new Error('Image upload failed');
            const data = await res.json();
            if (!data.url) throw new Error('Invalid upload response');

            return { default: data.url };
        }

        abort() {}
    }

    function uploadPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            const slugInput = form.querySelector('input[name="slug"]');
            return new UploadAdapter(loader, slugInput?.value || 'cms-page');
        };
    }

    function initEditor(el) {
        if (!el || editors.has(el) || !window.ClassicEditor) return;
        window.ClassicEditor.create(el, {
            toolbar: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', 'imageUpload'],
            extraPlugins: [uploadPlugin],
        }).then((editor) => {
            editors.set(el, editor);
        }).catch(() => {});
    }

    function initRichEditors() {
        const targets = Array.from(form.querySelectorAll('textarea.rich-editor'));
        if (!targets.length) return;

        const mount = () => targets.forEach((el) => initEditor(el));
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
        const rows = Array.from(form.querySelectorAll('#faq-rows .faq-row'));
        rows.forEach((row, index) => {
            const title = row.querySelector('input');
            const detail = row.querySelector('textarea');
            const label = row.querySelector('p');
            if (label) label.textContent = 'FAQ ' + (index + 1);
            if (title) title.name = `faqs[${index}][title]`;
            if (detail) detail.name = `faqs[${index}][detail]`;
        });
    }

    function reindexFaqGroups() {
        const groups = Array.from(form.querySelectorAll('#faq-group-rows .faq-group-row'));
        groups.forEach((group, gIdx) => {
            group.dataset.groupIndex = String(gIdx);
            const groupLabel = group.querySelector('p.text-sm');
            if (groupLabel) groupLabel.textContent = 'Group ' + (gIdx + 1);

            const categoryInput = group.querySelector('input');
            if (categoryInput) categoryInput.name = `faq_groups[${gIdx}][category]`;

            const items = Array.from(group.querySelectorAll('.group-faq-item'));
            items.forEach((item, iIdx) => {
                const itemLabel = item.querySelector('p.text-xs');
                if (itemLabel) itemLabel.textContent = 'Item ' + (iIdx + 1);
                const title = item.querySelector('input');
                const detail = item.querySelector('textarea');
                if (title) title.name = `faq_groups[${gIdx}][items][${iIdx}][title]`;
                if (detail) detail.name = `faq_groups[${gIdx}][items][${iIdx}][detail]`;
            });
        });
    }

    function getEditorData(textarea) {
        const editor = editors.get(textarea);
        if (!editor) return textarea?.value || '';
        return editor.getData() || '';
    }

    function extractFaqMainEntity() {
        return Array.from(form.querySelectorAll('#faq-rows .faq-row')).map((row) => {
            const titleInput = row.querySelector('input[name*="[title]"]');
            const detailArea = row.querySelector('textarea[name*="[detail]"]');
            const title = (titleInput?.value || '').trim();
            const detail = getEditorData(detailArea).trim();
            if (!title || !detail) return null;
            return {
                '@type': 'Question',
                name: title,
                acceptedAnswer: { '@type': 'Answer', text: detail },
            };
        }).filter(Boolean);
    }

    function extractGroupedFaqMainEntity() {
        const groups = Array.from(form.querySelectorAll('#faq-group-rows .faq-group-row'));
        return groups.map((group) => {
            const categoryInput = group.querySelector('input[name*="[category]"]');
            const category = (categoryInput?.value || '').trim();
            const items = Array.from(group.querySelectorAll('.group-faq-item')).map((item) => {
                const titleInput = item.querySelector('input[name*="[title]"]');
                const detailArea = item.querySelector('textarea[name*="[detail]"]');
                const title = (titleInput?.value || '').trim();
                const detail = getEditorData(detailArea).trim();
                if (!title || !detail) return null;
                return {
                    '@type': 'Question',
                    name: title,
                    acceptedAnswer: { '@type': 'Answer', text: detail },
                };
            }).filter(Boolean);

            if (!category || !items.length) return null;
            return { category, items };
        }).filter(Boolean);
    }

    function updateSchemaFaqs() {
        const schemaField = form.querySelector('#schema_json_field');
        if (!schemaField) return 0;

        const faqMainEntity = extractFaqMainEntity();
        const groupedFaq = extractGroupedFaqMainEntity();
        const groupedItems = groupedFaq.flatMap((g) => g.items);
        const allFaq = [...faqMainEntity, ...groupedItems];
        let schemaObj = {};
        try {
            schemaObj = schemaField.value?.trim() ? JSON.parse(schemaField.value) : {};
        } catch (err) {
            throw new Error('Schema JSON is invalid. Please fix it first.');
        }

        let graph = Array.isArray(schemaObj['@graph']) ? [...schemaObj['@graph']] : [];
        if (!graph.length && schemaObj['@type']) graph.push(schemaObj);

        const faqNode = {
            '@type': 'FAQPage',
            mainEntity: allFaq,
            hasPart: groupedFaq.map((g) => ({
                '@type': 'FAQPage',
                name: g.category,
                mainEntity: g.items,
            })),
        };
        const faqIndex = graph.findIndex((node) => node && node['@type'] === 'FAQPage');
        if (faqIndex >= 0) graph[faqIndex] = faqNode; else graph.push(faqNode);

        schemaField.value = JSON.stringify({
            ['@' + 'context']: schemaObj['@' + 'context'] || 'https://schema.org',
            '@graph': graph,
        }, null, 2);

        return allFaq.length;
    }

    function show(i) {
        idx = Math.max(0, Math.min(order.length - 1, i));
        order.forEach((key, n) => {
            const panel = form.querySelector('[data-cms-panel="' + key + '"]');
            const tab = form.querySelector('[data-cms-tab="' + key + '"]');
            if (panel) panel.classList.toggle('hidden', n !== idx);
            if (tab) {
                tab.classList.toggle('border-orange-500/55', n === idx);
                tab.classList.toggle('bg-slate-800', n === idx);
            }
        });
    }

    order.forEach((key, n) => {
        form.querySelector('[data-cms-tab="' + key + '"]')?.addEventListener('click', () => show(n));
    });

    form.querySelector('#cms-tab-back')?.addEventListener('click', () => show(idx - 1));
    form.querySelector('#cms-tab-next')?.addEventListener('click', () => show(idx + 1));

    form.querySelector('#add-faq-row')?.addEventListener('click', () => {
        const rowsWrap = form.querySelector('#faq-rows');
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
        initEditor(row.querySelector('textarea.rich-editor'));
    });

    form.querySelector('#add-faq-group')?.addEventListener('click', () => {
        const groupsWrap = form.querySelector('#faq-group-rows');
        if (!groupsWrap) return;

        const group = document.createElement('div');
        group.className = 'faq-group-row border border-slate-800 rounded-lg p-3 bg-slate-800/40';
        group.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <p class="text-sm text-slate-300">Group</p>
                <button type="button" class="btn btn-secondary remove-faq-group">Remove Group</button>
            </div>
            <input placeholder="Category title (e.g. General Questions)" class="mb-3">
            <div class="group-faq-items space-y-2">
                <div class="group-faq-item border border-slate-700 rounded-lg p-2 bg-slate-900/40">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-xs text-slate-400">Item</p>
                        <button type="button" class="btn btn-secondary remove-group-faq-item">Remove Item</button>
                    </div>
                    <input placeholder="Question" class="mb-2">
                    <textarea placeholder="Answer" class="rich-editor"></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mt-3 add-group-faq-item">Add Group FAQ</button>
        `;
        groupsWrap.appendChild(group);
        reindexFaqGroups();
        initEditor(group.querySelector('textarea.rich-editor'));
    });

    form.querySelector('#faq-rows')?.addEventListener('click', (event) => {
        const btn = event.target.closest('.remove-faq-row');
        if (!btn) return;

        const rowsWrap = form.querySelector('#faq-rows');
        const row = btn.closest('.faq-row');
        if (!rowsWrap || !row) return;
        row.remove();
        if (!rowsWrap.querySelector('.faq-row')) {
            form.querySelector('#add-faq-row')?.click();
        } else {
            reindexFaqRows();
        }
    });

    form.querySelector('#faq-group-rows')?.addEventListener('click', (event) => {
        const removeGroupBtn = event.target.closest('.remove-faq-group');
        if (removeGroupBtn) {
            const groupsWrap = form.querySelector('#faq-group-rows');
            const group = removeGroupBtn.closest('.faq-group-row');
            if (!groupsWrap || !group) return;
            group.remove();
            if (!groupsWrap.querySelector('.faq-group-row')) {
                form.querySelector('#add-faq-group')?.click();
            } else {
                reindexFaqGroups();
            }
            return;
        }

        const addItemBtn = event.target.closest('.add-group-faq-item');
        if (addItemBtn) {
            const group = addItemBtn.closest('.faq-group-row');
            const itemsWrap = group?.querySelector('.group-faq-items');
            if (!group || !itemsWrap) return;
            const item = document.createElement('div');
            item.className = 'group-faq-item border border-slate-700 rounded-lg p-2 bg-slate-900/40';
            item.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <p class="text-xs text-slate-400">Item</p>
                    <button type="button" class="btn btn-secondary remove-group-faq-item">Remove Item</button>
                </div>
                <input placeholder="Question" class="mb-2">
                <textarea placeholder="Answer" class="rich-editor"></textarea>
            `;
            itemsWrap.appendChild(item);
            reindexFaqGroups();
            initEditor(item.querySelector('textarea.rich-editor'));
            return;
        }

        const removeItemBtn = event.target.closest('.remove-group-faq-item');
        if (removeItemBtn) {
            const group = removeItemBtn.closest('.faq-group-row');
            const itemsWrap = group?.querySelector('.group-faq-items');
            const item = removeItemBtn.closest('.group-faq-item');
            if (!group || !itemsWrap || !item) return;
            item.remove();
            if (!itemsWrap.querySelector('.group-faq-item')) {
                const addBtn = group.querySelector('.add-group-faq-item');
                if (addBtn instanceof HTMLButtonElement) addBtn.click();
            } else {
                reindexFaqGroups();
            }
        }
    });

    form.querySelector('#sync-faq-to-schema')?.addEventListener('click', (event) => {
        try {
            const count = updateSchemaFaqs();
            const bumpField = form.querySelector('#bump_faq_schema');
            if (bumpField) bumpField.value = '1';
            const btn = event.currentTarget;
            if (btn instanceof HTMLButtonElement) {
                btn.textContent = `Schema Synced (${count})`;
                setTimeout(() => { btn.textContent = 'Update FAQ Schema Version'; }, 1600);
            }
        } catch (err) {
            alert(err?.message || 'Failed to update FAQ schema.');
        }
    });

    form.querySelector('#sync-grouped-faq-to-schema')?.addEventListener('click', (event) => {
        try {
            const count = updateSchemaFaqs();
            const bumpField = form.querySelector('#bump_faq_schema');
            if (bumpField) bumpField.value = '1';
            const btn = event.currentTarget;
            if (btn instanceof HTMLButtonElement) {
                btn.textContent = `Schema Synced (${count})`;
                setTimeout(() => { btn.textContent = 'Update FAQ Schema Version'; }, 1600);
            }
        } catch (err) {
            alert(err?.message || 'Failed to update FAQ schema.');
        }
    });

    initRichEditors();
    reindexFaqRows();
    reindexFaqGroups();
    show(0);
})();
</script>
