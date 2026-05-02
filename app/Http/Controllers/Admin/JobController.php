<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->get();

        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        $data = $validated['job'];
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
        if ($data['status'] === 'open') {
            $data['published_at'] = now();
        }

        $job = Job::create($data);
        $this->storeSeoMeta($job, $validated['seo']);

        return redirect()->route('admin.jobs.index')->with('success', 'Job posted successfully.');
    }

    public function edit(Job $job)
    {
        $job->load('seoMeta');

        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $this->validateData($request, $job);
        $data = $validated['job'];
        if ($data['status'] === 'open' && ! $job->published_at) {
            $data['published_at'] = now();
        }

        $job->update($data);
        $this->storeSeoMeta($job, $validated['seo']);

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated.');
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return back()->with('success', 'Job removed.');
    }

    private function validateData(Request $request, ?Job $job = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'icon_class' => ['nullable', 'string', 'max:191'],
            'department' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'work_mode' => ['nullable', 'string', 'max:100'],
            'experience_level' => ['nullable', 'string', 'max:100'],
            'min_experience_years' => ['required', 'integer', 'min:0', 'max:60'],
            'max_experience_years' => ['nullable', 'integer', 'min:0', 'max:60'],
            'education_requirements' => ['nullable', 'string'],
            'required_skills' => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'salary_range' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'open', 'closed'])],
            'deadline' => ['nullable', 'date'],
            'seo.seo_enabled' => ['nullable', 'boolean'],
            'seo.is_indexable' => ['nullable', 'boolean'],
            'seo.include_in_sitemap' => ['nullable', 'boolean'],
            'seo.slug' => ['nullable', 'string', 'max:255'],
            'seo.canonical_url' => ['nullable', 'url', 'max:255'],
            'seo.meta_title' => ['nullable', 'string', 'max:255'],
            'seo.meta_description' => ['nullable', 'string'],
            'seo.meta_keywords' => ['nullable', 'string'],
            'seo.meta_author' => ['nullable', 'string', 'max:255'],
            'seo.meta_viewport' => ['nullable', 'string', 'max:255'],
            'seo.focus_keyword' => ['nullable', 'string', 'max:255'],
            'seo.robots_directive' => ['nullable', 'string', 'max:255'],
            'seo.og_type' => ['nullable', 'string', 'max:50'],
            'seo.og_title' => ['nullable', 'string', 'max:255'],
            'seo.og_description' => ['nullable', 'string'],
            'seo.og_url' => ['nullable', 'url', 'max:255'],
            'seo.og_site_name' => ['nullable', 'string', 'max:255'],
            'seo.og_image' => ['nullable', 'url', 'max:255'],
            'seo.twitter_card' => ['nullable', 'string', 'max:50'],
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

        unset($validated['seo']);

        $allowedIcons = array_column(config('job_icon_picker.icons'), 'class');
        $defaultIcon = config('job_icon_picker.default');
        $iconClass = trim((string) ($validated['icon_class'] ?? ''));
        if ($iconClass === '' || ! in_array($iconClass, $allowedIcons, true)) {
            $validated['icon_class'] = $defaultIcon;
        } else {
            $validated['icon_class'] = $iconClass;
        }

        return [
            'job' => $validated,
            'seo' => $seo,
        ];
    }

    private function storeSeoMeta(Job $job, array $seo): void
    {
        $defaults = [
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'og_type' => 'website',
            'og_site_name' => 'HilDes',
            'twitter_card' => 'summary_large_image',
            'robots_directive' => 'index,follow',
        ];

        foreach ($defaults as $key => $value) {
            if (! isset($seo[$key]) || trim((string) $seo[$key]) === '') {
                $seo[$key] = $value;
            }
        }

        $plainDescription = trim(strip_tags((string) $job->description));

        if (trim((string) ($seo['meta_title'] ?? '')) === '') {
            $seo['meta_title'] = $job->title;
        }

        if (trim((string) ($seo['meta_description'] ?? '')) === '' && $plainDescription !== '') {
            $seo['meta_description'] = Str::limit($plainDescription, 300);
        }

        if (trim((string) ($seo['og_title'] ?? '')) === '' && trim((string) ($seo['meta_title'] ?? '')) !== '') {
            $seo['og_title'] = $seo['meta_title'];
        }

        if (trim((string) ($seo['og_description'] ?? '')) === '' && trim((string) ($seo['meta_description'] ?? '')) !== '') {
            $seo['og_description'] = $seo['meta_description'];
        }

        if (trim((string) ($seo['twitter_title'] ?? '')) === '' && trim((string) ($seo['meta_title'] ?? '')) !== '') {
            $seo['twitter_title'] = $seo['meta_title'];
        }

        if (trim((string) ($seo['twitter_description'] ?? '')) === '' && trim((string) ($seo['meta_description'] ?? '')) !== '') {
            $seo['twitter_description'] = $seo['meta_description'];
        }

        if (trim((string) ($seo['twitter_image'] ?? '')) === '' && trim((string) ($seo['og_image'] ?? '')) !== '') {
            $seo['twitter_image'] = $seo['og_image'];
        }

        $job->seoMeta()->updateOrCreate([], $seo);
    }
}
