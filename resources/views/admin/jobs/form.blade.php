@csrf
@php($job = $job ?? null)
@php($seo = $job?->seoMeta)
@php($jobIconDefault = config('job_icon_picker.default'))
@php($currentJobIcon = old('icon_class', $job?->icon_class ?? $jobIconDefault))
<div class="grid md:grid-cols-2 gap-4 bg-slate-900 p-6 panel">
    <input name="title" required value="{{ old('title', $job?->title ?? '') }}" placeholder="Job title">
    <div class="md:col-span-2 flex flex-wrap items-center gap-4 rounded-lg border border-slate-700 bg-slate-800/50 p-4">
        <div class="flex items-center gap-3">
            <span class="text-sm text-slate-400">Job icon</span>
            <span id="job-icon-preview" class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-slate-600 bg-slate-900 text-2xl text-[#ff9b5c]" aria-hidden="true">
                <i id="job-icon-preview-i" class="{{ $currentJobIcon }}"></i>
            </span>
        </div>
        <input type="hidden" name="icon_class" id="job-icon-class-input" value="{{ $currentJobIcon }}">
        <button type="button" class="btn btn-secondary" id="job-icon-open-modal">Browse icons</button>
        <p class="text-xs text-slate-500 w-full">Search Font Awesome icons in the popup and click one to assign.</p>
    </div>
    <input name="department" value="{{ old('department', $job?->department ?? '') }}" placeholder="Department">
    <input name="employment_type" value="{{ old('employment_type', $job?->employment_type ?? '') }}" placeholder="Employment type">
    <input name="location" value="{{ old('location', $job?->location ?? '') }}" placeholder="Location">
    <input name="work_mode" value="{{ old('work_mode', $job?->work_mode ?? '') }}" placeholder="Work mode">
    <input name="experience_level" value="{{ old('experience_level', $job?->experience_level ?? '') }}" placeholder="Experience level">
    <input name="min_experience_years" type="number" min="0" value="{{ old('min_experience_years', $job?->min_experience_years ?? 0) }}" placeholder="Min experience years">
    <input name="max_experience_years" type="number" min="0" value="{{ old('max_experience_years', $job?->max_experience_years ?? '') }}" placeholder="Max experience years">
    <input name="salary_range" value="{{ old('salary_range', $job?->salary_range ?? '') }}" placeholder="Salary range">
    <input name="deadline" type="date" value="{{ old('deadline', $job?->deadline ? $job->deadline->format('Y-m-d') : '') }}">
    <div>
        <p class="text-sm mb-2">Job status</p>
        <div class="option-pills">
            @foreach(['draft','open','closed'] as $s)
                @php($sid = 'job_status_' . $s)
                <input id="{{ $sid }}" type="radio" name="status" value="{{ $s }}" @checked(old('status', $job?->status ?? 'open') === $s)>
                <label for="{{ $sid }}">{{ ucfirst($s) }}</label>
            @endforeach
        </div>
    </div>
    <textarea name="education_requirements" placeholder="Education requirements">{{ old('education_requirements', $job?->education_requirements ?? '') }}</textarea>
    <textarea name="required_skills" placeholder="Required skills" class="md:col-span-2">{{ old('required_skills', $job?->required_skills ?? '') }}</textarea>
    <textarea name="responsibilities" placeholder="Responsibilities" class="md:col-span-2">{{ old('responsibilities', $job?->responsibilities ?? '') }}</textarea>
    <textarea name="description" placeholder="Full job description" class="md:col-span-2">{{ old('description', $job?->description ?? '') }}</textarea>

    <div class="md:col-span-2 mt-1">
        <h3 class="heading-text text-lg mb-1">SEO Section</h3>
        <p class="text-sm text-slate-400 mb-3">Meta tags, Open Graph, Twitter, canonical, robots and JSON-LD — aligned with CMS pages. Empty meta title / descriptions are filled from the job on save when possible.</p>
    </div>

    <label class="inline-flex items-center gap-2"><input type="checkbox" name="seo[seo_enabled]" value="1" @checked(old('seo.seo_enabled', $seo?->seo_enabled ?? true))> Enable SEO</label>
    <label class="inline-flex items-center gap-2"><input type="checkbox" name="seo[is_indexable]" value="1" @checked(old('seo.is_indexable', $seo?->is_indexable ?? true))> Indexable</label>
    <label class="inline-flex items-center gap-2 md:col-span-2"><input type="checkbox" name="seo[include_in_sitemap]" value="1" @checked(old('seo.include_in_sitemap', $seo?->include_in_sitemap ?? true))> Include in sitemap</label>

    <input name="seo[meta_title]" value="{{ old('seo.meta_title', $seo?->meta_title ?? '') }}" placeholder="Meta title">
    <input name="seo[meta_author]" value="{{ old('seo.meta_author', $seo?->meta_author ?? 'HilDes') }}" placeholder="Meta author">
    <textarea name="seo[meta_description]" placeholder="Meta description">{{ old('seo.meta_description', $seo?->meta_description ?? '') }}</textarea>
    <textarea name="seo[meta_keywords]" placeholder="Meta keywords">{{ old('seo.meta_keywords', $seo?->meta_keywords ?? '') }}</textarea>
    <input name="seo[meta_viewport]" value="{{ old('seo.meta_viewport', $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0') }}" placeholder="Meta viewport">
    <input name="seo[focus_keyword]" value="{{ old('seo.focus_keyword', $seo?->focus_keyword ?? '') }}" placeholder="Focus keyword">
    <input name="seo[robots_directive]" value="{{ old('seo.robots_directive', $seo?->robots_directive ?? 'index, follow') }}" placeholder="Robots directive">
    <input name="seo[canonical_url]" value="{{ old('seo.canonical_url', $seo?->canonical_url ?? '') }}" placeholder="Canonical URL (https://www.hildes.io/...)">
    <input name="seo[slug]" value="{{ old('seo.slug', $seo?->slug ?? '') }}" placeholder="SEO slug (optional)">

    <input name="seo[og_type]" value="{{ old('seo.og_type', $seo?->og_type ?? 'website') }}" placeholder="OG type">
    <input name="seo[og_title]" value="{{ old('seo.og_title', $seo?->og_title ?? '') }}" placeholder="Open Graph title">
    <textarea name="seo[og_description]" placeholder="Open Graph description">{{ old('seo.og_description', $seo?->og_description ?? '') }}</textarea>
    <input name="seo[og_url]" value="{{ old('seo.og_url', $seo?->og_url ?? '') }}" placeholder="Open Graph URL">
    <input name="seo[og_site_name]" value="{{ old('seo.og_site_name', $seo?->og_site_name ?? 'HilDes') }}" placeholder="Open Graph site name">
    <input name="seo[og_image]" value="{{ old('seo.og_image', $seo?->og_image ?? '') }}" placeholder="Open Graph image URL">

    <input name="seo[twitter_card]" value="{{ old('seo.twitter_card', $seo?->twitter_card ?? 'summary_large_image') }}" placeholder="Twitter card">
    <input name="seo[twitter_title]" value="{{ old('seo.twitter_title', $seo?->twitter_title ?? '') }}" placeholder="Twitter title">
    <textarea name="seo[twitter_description]" placeholder="Twitter description">{{ old('seo.twitter_description', $seo?->twitter_description ?? '') }}</textarea>
    <input name="seo[twitter_image]" value="{{ old('seo.twitter_image', $seo?->twitter_image ?? '') }}" placeholder="Twitter image URL">

    <div class="md:col-span-2">
        <textarea name="seo[schema_json]" class="w-full min-h-[170px]" placeholder='{"@@context":"https://schema.org","@@type":"JobPosting",...}'>{{ old('seo.schema_json', $seo?->schema_json ?? '') }}</textarea>
        <p class="text-sm text-slate-400 mt-2">Use valid JSON-LD. For listings, <code class="text-slate-300">JobPosting</code> is recommended (title, description, datePosted, hiringOrganization, jobLocation or applicantLocationRequirements, employmentType, baseSalary where applicable). Use <code class="text-slate-300">https://www.hildes.io</code> in URLs.</p>
    </div>

    <button class="md:col-span-2 btn btn-primary form-submit">Save Job</button>
</div>

<div id="job-icon-modal" class="fixed inset-0 z-[200] hidden items-center justify-center bg-black/70 p-4" aria-hidden="true">
    <div class="relative flex max-h-[90vh] w-full max-w-4xl flex-col overflow-hidden rounded-xl border border-slate-700 bg-slate-900 shadow-2xl" role="dialog" aria-modal="true" aria-labelledby="job-icon-modal-title">
        <div class="flex items-center justify-between border-b border-slate-700 p-4">
            <h4 id="job-icon-modal-title" class="heading-text text-base m-0">Choose an icon</h4>
            <button type="button" class="btn btn-secondary" id="job-icon-modal-close">Close</button>
        </div>
        <div class="border-b border-slate-700 p-4">
            <input type="search" id="job-icon-search" class="w-full rounded-md border border-slate-600 bg-slate-800 px-3 py-2 text-sm text-slate-100 placeholder-slate-500" placeholder="Search by name (e.g. briefcase, chart, react)…" autocomplete="off">
        </div>
        <div class="min-h-0 flex-1 overflow-y-auto p-4">
            <div class="grid grid-cols-6 gap-2 sm:grid-cols-8 md:grid-cols-10" id="job-icon-grid">
                @foreach(config('job_icon_picker.icons') as $icon)
                    <button
                        type="button"
                        class="job-icon-choice flex h-11 w-11 items-center justify-center rounded border border-slate-600 bg-slate-800 text-lg text-slate-200 hover:border-[#ff6600] hover:text-[#ffb07a]"
                        data-icon-class="{{ $icon['class'] }}"
                        data-search="{{ e($icon['search']) }}"
                        title="{{ $icon['class'] }}"
                    >
                        <i class="{{ $icon['class'] }}" aria-hidden="true"></i>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var modal = document.getElementById('job-icon-modal');
    var openBtn = document.getElementById('job-icon-open-modal');
    var closeBtn = document.getElementById('job-icon-modal-close');
    var search = document.getElementById('job-icon-search');
    var input = document.getElementById('job-icon-class-input');
    var previewI = document.getElementById('job-icon-preview-i');
    if (!modal || !openBtn || !input || !previewI) return;

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        if (search) {
            search.value = '';
            filterIcons('');
            search.focus();
        }
    }
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
    }
    function filterIcons(q) {
        var needle = (q || '').toLowerCase().trim();
        modal.querySelectorAll('.job-icon-choice').forEach(function (btn) {
            var hay = (btn.getAttribute('data-search') || '').toLowerCase();
            btn.style.display = !needle || hay.indexOf(needle) !== -1 ? '' : 'none';
        });
    }
    function selectIcon(className) {
        input.value = className;
        previewI.className = className;
        closeModal();
    }

    openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });
    if (search) {
        search.addEventListener('input', function () {
            filterIcons(search.value);
        });
    }
    modal.querySelectorAll('.job-icon-choice').forEach(function (btn) {
        btn.addEventListener('click', function () {
            selectIcon(btn.getAttribute('data-icon-class') || '');
        });
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });
})();
</script>
