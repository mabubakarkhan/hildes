<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use App\Notifications\NewJobApplicationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CareerJobController extends Controller
{
    public function show(Job $job)
    {
        $this->authorizePublicJob($job);

        $job->loadMissing('seoMeta');
        $seo = $job->seoMeta;

        $plainDesc = strip_tags((string) $job->description);
        $canonicalUrl = $seo?->canonical_url ?: route('careers.job.show', ['job' => $job->slug]);
        $ogImage = $seo?->og_image;
        $twitterImage = $seo?->twitter_image ?: $ogImage;
        $metaDescription = $seo?->meta_description ?: Str::limit(trim($plainDesc), 160);

        $robotsDirective = $seo?->robots_directive;
        if ($robotsDirective === null || $robotsDirective === '') {
            $robotsDirective = (($seo && ! $seo->is_indexable) ? 'noindex,nofollow' : 'index,follow');
        }

        return view('frontend.job-detail', [
            'job' => $job,
            'metaTitle' => $seo?->meta_title ?: ($job->title.' | Careers | HilDes'),
            'metaDescription' => $metaDescription,
            'metaKeywords' => $seo?->meta_keywords ?: ($job->department.', '.$job->employment_type.', careers, HilDes'),
            'metaRobots' => $robotsDirective,
            'canonicalUrl' => $canonicalUrl,
            'metaAuthor' => $seo?->meta_author ?? 'HilDes',
            'metaViewport' => $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0',
            'ogType' => $seo?->og_type ?? 'website',
            'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?? $job->title),
            'ogDescription' => $seo?->og_description ?: $metaDescription,
            'ogUrl' => $seo?->og_url ?: $canonicalUrl,
            'ogSiteName' => $seo?->og_site_name ?? 'HilDes',
            'ogImage' => $ogImage,
            'twitterCard' => $seo?->twitter_card ?? 'summary_large_image',
            'twitterTitle' => $seo?->twitter_title ?: ($seo?->meta_title ?? $job->title),
            'twitterDescription' => $seo?->twitter_description ?: $metaDescription,
            'twitterImage' => $twitterImage,
            'schemaJson' => $seo?->schema_json,
        ]);
    }

    public function apply(Request $request, Job $job)
    {
        $this->authorizePublicJob($job);

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'education_level' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:60'],
            'skills' => ['nullable', 'string', 'max:10000'],
            'cover_letter' => ['nullable', 'string', 'max:10000'],
            'cv_file' => ['nullable', 'file', 'max:5120'],
        ]);

        $data['job_id'] = $job->id;

        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = $request->file('cv_file')->store('applications/cv', 'public');
        }

        $application = JobApplication::create($data);

        User::query()->where('is_admin', true)->each(function (User $admin) use ($application): void {
            $admin->notify(new NewJobApplicationNotification($application));
        });

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you — we’ve received your application.',
            ]);
        }

        return redirect()
            ->route('careers.job.show', ['job' => $job->slug])
            ->withFragment('apply')
            ->with('flash_application_success', true);
    }

    private function authorizePublicJob(Job $job): void
    {
        abort_unless($job->status === 'open', 404);

        if ($job->deadline && $job->deadline->isPast()) {
            abort(404);
        }
    }
}
