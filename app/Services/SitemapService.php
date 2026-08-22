<?php

namespace App\Services;

use App\Models\CaseStudy;
use App\Models\CmsPage;
use App\Models\Job;
use App\Models\SeoMeta;
use App\Models\ServicePage;
use Illuminate\Support\Collection;

class SitemapService
{
    public function __construct(
        private readonly WordPressSitemapService $wordPressSitemapService,
    ) {
    }

    public function toXml(): string
    {
        $entries = $this->getEntries()
            ->unique(fn (array $entry): string => $entry['loc'])
            ->values();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($entries as $entry) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($entry['loc'], ENT_XML1 | ENT_COMPAT, 'UTF-8')."</loc>\n";

            if (! empty($entry['lastmod'])) {
                $xml .= '    <lastmod>'.htmlspecialchars((string) $entry['lastmod'], ENT_XML1 | ENT_COMPAT, 'UTF-8')."</lastmod>\n";
            }

            if (isset($entry['priority'])) {
                $xml .= '    <priority>'.number_format((float) $entry['priority'], 2, '.', '')."</priority>\n";
            }

            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    public function getEntries(): Collection
    {
        return collect()
            ->concat($this->cmsPageEntries())
            ->concat($this->serviceEntries())
            ->concat($this->caseStudyEntries())
            ->concat($this->jobEntries())
            ->concat($this->wordPressSitemapService->getEntries());
    }

    private function cmsPageEntries(): Collection
    {
        $routeBySlug = [
            'home' => 'home',
            'about' => 'about',
            'contact-us' => 'contact',
            'services' => 'services.index',
            'case-studies' => 'case-studies.index',
            'faqs' => 'faqs.page',
            'careers' => 'careers.page',
            'get-a-quote' => 'quote',
            'why-us' => 'why-us.page',
            'privacy-policy' => 'privacy.page',
            'terms-and-conditions' => 'terms.page',
            'sla' => 'sla.page',
        ];

        return CmsPage::query()
            ->where('is_published', true)
            ->with('seoMeta')
            ->get()
            ->map(function (CmsPage $page) use ($routeBySlug): ?array {
                if (! $this->shouldIncludeInSitemap($page->seoMeta)) {
                    return null;
                }

                $routeName = $routeBySlug[$page->slug] ?? null;
                if ($routeName === null) {
                    return null;
                }

                return [
                    'loc' => route($routeName),
                    'lastmod' => optional($page->updated_at)->toAtomString(),
                    'priority' => $page->slug === 'home' ? 1.0 : 0.8,
                ];
            })
            ->filter()
            ->values();
    }

    private function serviceEntries(): Collection
    {
        return ServicePage::query()
            ->where('is_published', true)
            ->with('seoMeta')
            ->ordered()
            ->get()
            ->map(function (ServicePage $service): ?array {
                if (! $this->shouldIncludeInSitemap($service->seoMeta)) {
                    return null;
                }

                return [
                    'loc' => route('service.slug', ['slug' => $service->slug]),
                    'lastmod' => optional($service->updated_at)->toAtomString(),
                    'priority' => 0.8,
                ];
            })
            ->filter()
            ->values();
    }

    private function caseStudyEntries(): Collection
    {
        return CaseStudy::query()
            ->where('is_published', true)
            ->with('seoMeta')
            ->ordered()
            ->get()
            ->map(function (CaseStudy $caseStudy): ?array {
                if (! $this->shouldIncludeInSitemap($caseStudy->seoMeta)) {
                    return null;
                }

                return [
                    'loc' => route('case-studies.show', ['slug' => $caseStudy->slug]),
                    'lastmod' => optional($caseStudy->updated_at)->toAtomString(),
                    'priority' => 0.8,
                ];
            })
            ->filter()
            ->values();
    }

    private function jobEntries(): Collection
    {
        return Job::query()
            ->where('status', 'open')
            ->with('seoMeta')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get()
            ->map(function (Job $job): ?array {
                if (! $this->shouldIncludeInSitemap($job->seoMeta)) {
                    return null;
                }

                return [
                    'loc' => route('careers.job.show', ['job' => $job->slug]),
                    'lastmod' => optional($job->updated_at ?? $job->published_at)->toAtomString(),
                    'priority' => 0.64,
                ];
            })
            ->filter()
            ->values();
    }

    private function shouldIncludeInSitemap(?SeoMeta $seo): bool
    {
        if ($seo && $seo->include_in_sitemap === false) {
            return false;
        }

        return true;
    }
}
