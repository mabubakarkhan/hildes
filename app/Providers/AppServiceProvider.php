<?php

namespace App\Providers;

use App\Models\ContactSetting;
use App\Models\CaseStudy;
use App\Models\Client;
use App\Models\HomeHeroSetting;
use App\Models\HomeHeroSlide;
use App\Models\SeoSetting;
use App\Models\ServicePage;
use App\Models\Testimonial;
use App\Services\WordPressRecentPostsService;
use App\View\Composers\HomeServiceHrefsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(
            [
                'frontend.partials.site-header',
                'frontend.partials.site-footer',
                'frontend.partials.site-home-body',
            ],
            function ($view): void {
                $contact = ContactSetting::query()->firstOrCreate([]);
                $view->with('contact', $contact);
                $view->with('quickActions', [
                    [
                        'show' => filled($contact->email),
                        'href' => filled($contact->email) ? $contact->mailtoHref() : '#',
                        'label' => 'Email',
                        'icon' => 'fas fa-envelope',
                        'extraClass' => 'is-email',
                        'target' => null,
                        'rel' => null,
                    ],
                    [
                        'show' => filled($contact->whatsapp),
                        'href' => filled($contact->whatsapp) ? $contact->whatsappHref() : '#',
                        'label' => 'WhatsApp',
                        'icon' => 'fab fa-whatsapp',
                        'extraClass' => 'is-whatsapp',
                        'target' => '_blank',
                        'rel' => 'noopener noreferrer',
                    ],
                    [
                        'show' => filled($contact->phone),
                        'href' => filled($contact->phone) ? $contact->telHref() : '#',
                        'label' => 'Call',
                        'icon' => 'fas fa-phone-alt',
                        'extraClass' => 'is-call',
                        'target' => null,
                        'rel' => null,
                    ],
                ]);
                $view->with(
                    'headerServices',
                    ServicePage::query()
                        ->where('is_published', true)
                        ->ordered()
                        ->get(['id', 'name', 'slug', 'hero_headline'])
                );
                $view->with(
                    'headerCaseStudies',
                    CaseStudy::query()
                        ->where('is_published', true)
                        ->ordered()
                        ->get(['id', 'title', 'slug', 'tagline', 'featured_image', 'featured_image_alt'])
                );
                $view->with(
                    'homepageClients',
                    Client::query()
                        ->where('is_active', true)
                        ->whereNotNull('logo')
                        ->ordered()
                        ->get(['id', 'name', 'website_url', 'logo', 'background_color'])
                );
                $searchServices = ServicePage::query()
                    ->where('is_published', true)
                    ->ordered()
                    ->get(['name', 'slug', 'hero_headline'])
                    ->map(fn (ServicePage $service) => [
                        'type' => 'service',
                        'title' => $service->name,
                        'summary' => strip_tags((string) $service->hero_headline),
                        'url' => route('service.slug', $service->slug),
                    ]);
                $searchCaseStudies = CaseStudy::query()
                    ->where('is_published', true)
                    ->ordered()
                    ->get(['title', 'slug', 'tagline'])
                    ->map(fn (CaseStudy $caseStudy) => [
                        'type' => 'case study',
                        'title' => $caseStudy->title,
                        'summary' => strip_tags((string) $caseStudy->tagline),
                        'url' => route('case-studies.show', $caseStudy->slug),
                    ]);
                $view->with(
                    'searchItems',
                    $searchServices
                        ->concat($searchCaseStudies)
                        ->values()
                );
            }
        );

        View::composer(
            [
                'frontend.partials.site-home-body',
                'frontend.partials.sections.about-talent-section',
                'frontend.partials.sections.hildes-grow-business-cta',
            ],
            HomeServiceHrefsComposer::class
        );

        View::composer('frontend.partials.site-home-body', function ($view): void {
            $view->with('heroSettings', HomeHeroSetting::getSingleton());
            $view->with(
                'heroSlides',
                HomeHeroSlide::query()
                    ->where('is_active', true)
                    ->whereNotNull('background_image')
                    ->with([
                        'service:id,slug',
                        'caseStudy:id,slug',
                    ])
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
            );
            $view->with(
                'homepageTestimonials',
                Testimonial::query()
                    ->where('is_active', true)
                    ->whereNotNull('image')
                    ->ordered()
                    ->get()
            );
            $view->with(
                'recentBlogPosts',
                app(WordPressRecentPostsService::class)->getRecent()
            );
        });

        View::composer('frontend.layouts.app', function ($view): void {
            $defaults = SeoSetting::getSingleton();
            $data = $view->getData();

            $merge = function (string $key, mixed $default) use ($data): mixed {
                $value = $data[$key] ?? null;

                return filled($value) ? $value : $default;
            };

            $metaTitle = $merge('metaTitle', $defaults->default_meta_title);
            $metaDescription = $merge('metaDescription', $defaults->default_meta_description);

            $siteOgImage = $defaults->defaultOgImageUrl();
            $siteTwitterImage = $defaults->defaultTwitterImageUrl() ?? $siteOgImage;
            $ogImage = SeoSetting::resolveShareImageUrl($data['ogImage'] ?? null) ?? $siteOgImage;
            $twitterImage = SeoSetting::resolveShareImageUrl($data['twitterImage'] ?? null) ?? $siteTwitterImage ?? $ogImage;

            $view->with([
                'metaTitle' => $metaTitle,
                'metaDescription' => $metaDescription,
                'metaKeywords' => $merge('metaKeywords', $defaults->default_meta_keywords),
                'metaAuthor' => $merge('metaAuthor', $defaults->default_meta_author),
                'metaRobots' => $merge('metaRobots', $defaults->default_robots_directive),
                'ogType' => $merge('ogType', $defaults->default_og_type),
                'ogSiteName' => $merge('ogSiteName', $defaults->og_site_name),
                'twitterCard' => $merge('twitterCard', $defaults->twitter_card),
                'ogImage' => $ogImage,
                'twitterImage' => $twitterImage,
                'ogTitle' => $merge('ogTitle', $metaTitle),
                'ogDescription' => $merge('ogDescription', $metaDescription),
                'twitterTitle' => $merge('twitterTitle', $metaTitle),
                'twitterDescription' => $merge('twitterDescription', $metaDescription),
            ]);
        });
    }
}
