<?php

use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\CaseStudyController;
use App\Http\Controllers\Admin\CmsPageController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeHeroController;
use App\Http\Controllers\Admin\HomeHeroSlideController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\LeadSubmissionController as AdminLeadSubmissionController;
use App\Http\Controllers\Admin\NewsletterSubscriptionController as AdminNewsletterSubscriptionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServicePageController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Frontend\LeadSubmissionController;
use App\Http\Controllers\Frontend\NewsletterSubscriptionController;
use App\Models\CaseStudy;
use App\Models\CmsPage;
use App\Http\Controllers\Frontend\CareerJobController;
use App\Models\Job;
use App\Models\ServicePage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $homePage = CmsPage::query()
        ->where('slug', 'home')
        ->where('is_published', true)
        ->with('seoMeta')
        ->first();
    $seo = $homePage?->seoMeta;

    return view('frontend.home', [
        'metaTitle' => $seo?->meta_title ?? 'HilDes - IT Services Company',
        'metaDescription' => $seo?->meta_description ?? 'HilDes delivers web, mobile, AI, digital marketing, SEO, and creative services for growth-focused businesses.',
        'metaKeywords' => $seo?->meta_keywords ?? 'HilDes, IT services, web development, mobile apps, AI solutions, digital marketing, SEO, graphics design',
        'metaRobots' => $seo?->robots_directive ?? 'index,follow',
        'canonicalUrl' => $seo?->canonical_url ?? url()->current(),
        'metaAuthor' => $seo?->meta_author ?? 'HilDes',
        'metaViewport' => $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0',
        'ogType' => $seo?->og_type ?? 'website',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?? null),
        'ogDescription' => $seo?->og_description ?: ($seo?->meta_description ?? null),
        'ogUrl' => $seo?->og_url ?: ($seo?->canonical_url ?? url()->current()),
        'ogSiteName' => $seo?->og_site_name ?? 'HilDes',
        'ogImage' => $seo?->og_image,
        'twitterCard' => $seo?->twitter_card ?? 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->meta_title ?? null),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->meta_description ?? null),
        'twitterImage' => $seo?->twitter_image,
        'schemaJson' => $seo?->schema_json,
    ]);
})->name('home');

$renderCmsSimplePage = function (string $slug, string $pre, string $bgTitle, string $heroTitle) {
    $page = CmsPage::query()
        ->where('slug', $slug)
        ->where('is_published', true)
        ->with('seoMeta')
        ->first();
    abort_unless($page, 404);

    $seo = $page->seoMeta;
    $pageFaqs = collect($page->faqs_json ?? [])
        ->map(function ($item) {
            return [
                'title' => trim((string) data_get($item, 'title', '')),
                'detail' => trim((string) data_get($item, 'detail', '')),
            ];
        })
        ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
        ->values();

    return view('frontend.cms-page', [
        'cmsPage' => $page,
        'cmsHeroPre' => $pre,
        'cmsHeroBgTitle' => $bgTitle,
        'cmsHeroTitle' => $heroTitle,
        'cmsFaqs' => $pageFaqs,
        'metaTitle' => $seo?->meta_title ?? ($page->title.' | HilDes'),
        'metaDescription' => $seo?->meta_description ?? \Illuminate\Support\Str::limit(strip_tags((string) $page->detail_content), 160),
        'metaKeywords' => $seo?->meta_keywords ?? '',
        'metaRobots' => $seo?->robots_directive ?? 'index,follow',
        'canonicalUrl' => $seo?->canonical_url ?? url()->current(),
        'metaAuthor' => $seo?->meta_author ?? 'HilDes',
        'metaViewport' => $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0',
        'ogType' => $seo?->og_type ?? 'website',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?? null),
        'ogDescription' => $seo?->og_description ?: ($seo?->meta_description ?? null),
        'ogUrl' => $seo?->og_url ?: ($seo?->canonical_url ?? url()->current()),
        'ogSiteName' => $seo?->og_site_name ?? 'HilDes',
        'ogImage' => $seo?->og_image,
        'twitterCard' => $seo?->twitter_card ?? 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->meta_title ?? null),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->meta_description ?? null),
        'twitterImage' => $seo?->twitter_image,
        'schemaJson' => $seo?->schema_json,
    ]);
};

Route::get('/admin', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    if (! Auth::user()?->is_admin) {
        abort(403);
    }

    return redirect()->route('admin.dashboard');
})->name('admin');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function (): void {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::resource('contact-settings', ContactSettingController::class)->only(['index', 'update']);
        Route::post('case-studies/upload-detail-image', [CaseStudyController::class, 'uploadDetailImage'])->name('case-studies.upload-detail-image');
        Route::get('case-studies/order', [CaseStudyController::class, 'order'])->name('case-studies.order');
        Route::put('case-studies/order', [CaseStudyController::class, 'updateOrder'])->name('case-studies.order.update');
        Route::resource('case-studies', CaseStudyController::class)->except(['show']);
        Route::get('services/order', [ServicePageController::class, 'order'])->name('services.order');
        Route::put('services/order', [ServicePageController::class, 'updateOrder'])->name('services.order.update');
        Route::resource('services', ServicePageController::class)->except(['show']);
        Route::get('clients/order', [ClientController::class, 'order'])->name('clients.order');
        Route::put('clients/order', [ClientController::class, 'updateOrder'])->name('clients.order.update');
        Route::get('clients/bulk-colors', [ClientController::class, 'bulkColors'])->name('clients.bulk-colors');
        Route::put('clients/bulk-colors', [ClientController::class, 'bulkColorsUpdate'])->name('clients.bulk-colors.update');
        Route::get('clients/bulk-upload', [ClientController::class, 'bulkCreate'])->name('clients.bulk-upload');
        Route::post('clients/bulk-upload', [ClientController::class, 'bulkStore'])->name('clients.bulk-upload.store');
        Route::resource('clients', ClientController::class)->except(['show']);
        Route::post('cms-pages/upload-detail-image', [CmsPageController::class, 'uploadDetailImage'])->name('cms-pages.upload-detail-image');
        Route::resource('cms-pages', CmsPageController::class)->except(['show']);
        Route::get('testimonials/order', [TestimonialController::class, 'order'])->name('testimonials.order');
        Route::put('testimonials/order', [TestimonialController::class, 'updateOrder'])->name('testimonials.order.update');
        Route::resource('testimonials', TestimonialController::class)->except(['show']);

        Route::prefix('home-hero')->name('home-hero.')->group(function (): void {
            Route::get('/', [HomeHeroController::class, 'index'])->name('index');
            Route::put('/settings', [HomeHeroController::class, 'updateSettings'])->name('settings.update');
            Route::resource('slides', HomeHeroSlideController::class)->except(['index', 'show']);
        });

        Route::resource('jobs', JobController::class)->except(['show']);
        Route::resource('applications', JobApplicationController::class)->except(['show']);
        Route::resource('lead-submissions', AdminLeadSubmissionController::class)->only(['index', 'destroy']);
        Route::resource('newsletter-subscriptions', AdminNewsletterSubscriptionController::class)->only(['index', 'destroy']);
        Route::resource('users', UserController::class)->except(['show']);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/notifications', function () {
            $notifications = DatabaseNotification::latest()->get();
            DatabaseNotification::whereNull('read_at')->update(['read_at' => now()]);

            return view('admin.notifications.index', compact('notifications'));
        })->name('notifications.index');
    });
});

Route::post('/lead-submissions', [LeadSubmissionController::class, 'store'])
    ->middleware('throttle:20,1')
    ->name('lead-submissions.store');
Route::post('/newsletter-subscriptions', [NewsletterSubscriptionController::class, 'store'])
    ->middleware('throttle:20,1')
    ->name('newsletter-subscriptions.store');

Route::get('/case-studies', function () {
    $caseStudies = CaseStudy::query()
        ->where('is_published', true)
        ->ordered()
        ->get(['id', 'title', 'slug', 'tagline', 'featured_image', 'featured_image_alt']);
    $caseStudiesPage = CmsPage::query()
        ->where('slug', 'case-studies')
        ->where('is_published', true)
        ->with('seoMeta')
        ->first();
    $seo = $caseStudiesPage?->seoMeta;
    $caseStudiesCmsFaqs = collect($caseStudiesPage?->faqs_json ?? [])
        ->map(function ($item) {
            return [
                'title' => trim((string) data_get($item, 'title', '')),
                'detail' => trim((string) data_get($item, 'detail', '')),
            ];
        })
        ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
        ->values();

    return view('frontend.case-studies', [
        'caseStudies' => $caseStudies,
        'caseStudiesCmsFaqs' => $caseStudiesCmsFaqs,
        'caseStudiesCmsDetail' => $caseStudiesPage?->detail_content,
        'metaTitle' => $seo?->meta_title ?? 'Case Studies | HilDes',
        'metaDescription' => $seo?->meta_description ?? 'Explore HilDes case studies and success stories across AI, SaaS, web, mobile, and DevOps projects.',
        'metaKeywords' => $seo?->meta_keywords ?? 'hildes case studies, success stories, ai projects, saas projects, portfolio',
        'metaRobots' => $seo?->robots_directive ?? 'index,follow',
        'canonicalUrl' => $seo?->canonical_url ?? url()->current(),
        'metaAuthor' => $seo?->meta_author ?? 'HilDes',
        'metaViewport' => $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0',
        'ogType' => $seo?->og_type ?? 'website',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?? null),
        'ogDescription' => $seo?->og_description ?: ($seo?->meta_description ?? null),
        'ogUrl' => $seo?->og_url ?: ($seo?->canonical_url ?? url()->current()),
        'ogSiteName' => $seo?->og_site_name ?? 'HilDes',
        'ogImage' => $seo?->og_image,
        'twitterCard' => $seo?->twitter_card ?? 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->meta_title ?? null),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->meta_description ?? null),
        'twitterImage' => $seo?->twitter_image,
        'schemaJson' => $seo?->schema_json,
    ]);
})->name('case-studies.index');

Route::get('/case-studies/{slug}', function (string $slug) {
    $caseStudy = CaseStudy::query()
        ->with('seoMeta')
        ->where('is_published', true)
        ->where('slug', $slug)
        ->firstOrFail();

    $seo = $caseStudy->seoMeta;
    $metaDescription = $seo?->meta_description ?: strip_tags((string) $caseStudy->short_description);
    $canonicalUrl = $seo?->canonical_url ?: url()->current();
    $ogImage = $seo?->og_image ?: ($caseStudy->featured_image_url ?: null);
    $twitterImage = $seo?->twitter_image ?: $ogImage;
    $robotsDirective = $seo?->robots_directive ?: (($seo && ! $seo->is_indexable) ? 'noindex,nofollow' : 'index,follow');

    return view('frontend.case-study-details', [
        'caseStudy' => $caseStudy,
        'sidebarCaseStudies' => CaseStudy::query()
            ->where('is_published', true)
            ->where('id', '!=', $caseStudy->id)
            ->ordered()
            ->get(['id', 'title', 'slug']),
        'sidebarServices' => ServicePage::query()
            ->where('is_published', true)
            ->ordered()
            ->get(['id', 'name', 'slug']),
        'metaTitle' => $seo?->meta_title ?: $caseStudy->title,
        'metaDescription' => $metaDescription,
        'metaKeywords' => $seo?->meta_keywords ?: 'case studies, portfolio, technology, hildes',
        'metaRobots' => $robotsDirective,
        'canonicalUrl' => $canonicalUrl,
        'ogType' => 'article',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?: $caseStudy->title),
        'ogDescription' => $seo?->og_description ?: $metaDescription,
        'ogUrl' => $canonicalUrl,
        'ogImage' => $ogImage,
        'twitterCard' => 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->og_title ?: ($seo?->meta_title ?: $caseStudy->title)),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->og_description ?: $metaDescription),
        'twitterImage' => $twitterImage,
        'schemaJson' => $seo?->schema_json,
    ]);
})->name('case-studies.show');

Route::get('/services', function () {
    $services = ServicePage::query()
        ->where('is_published', true)
        ->ordered()
        ->get(['id', 'name', 'slug', 'hero_headline', 'general_image', 'general_image_alt']);
    $servicesPage = CmsPage::query()
        ->where('slug', 'services')
        ->where('is_published', true)
        ->with('seoMeta')
        ->first();
    $seo = $servicesPage?->seoMeta;
    $servicesCmsFaqs = collect($servicesPage?->faqs_json ?? [])
        ->map(function ($item) {
            return [
                'title' => trim((string) data_get($item, 'title', '')),
                'detail' => trim((string) data_get($item, 'detail', '')),
            ];
        })
        ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
        ->values();

    return view('frontend.services', [
        'services' => $services,
        'servicesCmsDetail' => $servicesPage?->detail_content,
        'servicesCmsFaqs' => $servicesCmsFaqs,
        'metaTitle' => $seo?->meta_title ?? 'Services | HilDes',
        'metaDescription' => $seo?->meta_description ?? 'Explore HilDes services across web, mobile, AI, and cloud solutions.',
        'metaKeywords' => $seo?->meta_keywords ?? 'hildes services, web development, mobile app development, ai services, devops',
        'metaRobots' => $seo?->robots_directive ?? 'index,follow',
        'canonicalUrl' => $seo?->canonical_url ?? url()->current(),
        'metaAuthor' => $seo?->meta_author ?? 'HilDes',
        'metaViewport' => $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0',
        'ogType' => $seo?->og_type ?? 'website',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?? null),
        'ogDescription' => $seo?->og_description ?: ($seo?->meta_description ?? null),
        'ogUrl' => $seo?->og_url ?: ($seo?->canonical_url ?? url()->current()),
        'ogSiteName' => $seo?->og_site_name ?? 'HilDes',
        'ogImage' => $seo?->og_image,
        'twitterCard' => $seo?->twitter_card ?? 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->meta_title ?? null),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->meta_description ?? null),
        'twitterImage' => $seo?->twitter_image,
        'schemaJson' => $seo?->schema_json,
    ]);
})->name('services.index');

Route::get('/about-us', function () {
    $aboutPage = CmsPage::query()
        ->where('slug', 'about')
        ->where('is_published', true)
        ->with('seoMeta')
        ->first();
    $seo = $aboutPage?->seoMeta;
    $aboutCmsFaqs = collect($aboutPage?->faqs_json ?? [])
        ->map(function ($item) {
            return [
                'title' => trim((string) data_get($item, 'title', '')),
                'detail' => trim((string) data_get($item, 'detail', '')),
            ];
        })
        ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
        ->values();
    $aboutDetailHtml = (string) ($aboutPage?->detail_content ?? '');
    $aboutDetailTitle = null;
    $aboutDetailIntro = '';
    $aboutDetailSections = collect();
    if (trim($aboutDetailHtml) !== '') {
        if (preg_match('/<h2[^>]*>(.*?)<\/h2>/is', $aboutDetailHtml, $h2Match)) {
            $aboutDetailTitle = trim(strip_tags($h2Match[1]));
            $aboutDetailHtml = preg_replace('/<h2[^>]*>.*?<\/h2>/is', '', $aboutDetailHtml, 1) ?? $aboutDetailHtml;
        }

        $parts = preg_split('/<h3[^>]*>(.*?)<\/h3>/is', $aboutDetailHtml, -1, PREG_SPLIT_DELIM_CAPTURE);
        if (is_array($parts) && count($parts) > 0) {
            $aboutDetailIntro = trim((string) ($parts[0] ?? ''));
            $sections = [];
            for ($i = 1; $i < count($parts); $i += 2) {
                $heading = trim(strip_tags((string) ($parts[$i] ?? '')));
                $body = trim((string) ($parts[$i + 1] ?? ''));
                if ($heading !== '' || $body !== '') {
                    $sections[] = [
                        'heading' => $heading,
                        'body' => $body,
                    ];
                }
            }
            $aboutDetailSections = collect($sections);
        } else {
            $aboutDetailIntro = trim($aboutDetailHtml);
        }
    }

    return view('frontend.about', [
        'aboutCmsFaqs' => $aboutCmsFaqs,
        'aboutDetailTitle' => $aboutDetailTitle,
        'aboutDetailIntro' => $aboutDetailIntro,
        'aboutDetailSections' => $aboutDetailSections,
        'metaTitle' => $seo?->meta_title ?? 'About Us | HilDes',
        'metaDescription' => $seo?->meta_description ?? 'Learn about HilDes and our focus on AI solutions, SaaS engineering, and MVP development.',
        'metaKeywords' => $seo?->meta_keywords ?? 'about hildes, ai development company, saas product engineering, mvp development',
        'metaRobots' => $seo?->robots_directive ?? 'index,follow',
        'canonicalUrl' => $seo?->canonical_url ?? url()->current(),
        'metaAuthor' => $seo?->meta_author ?? 'HilDes',
        'metaViewport' => $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0',
        'ogType' => $seo?->og_type ?? 'website',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?? null),
        'ogDescription' => $seo?->og_description ?: ($seo?->meta_description ?? null),
        'ogUrl' => $seo?->og_url ?: ($seo?->canonical_url ?? url()->current()),
        'ogSiteName' => $seo?->og_site_name ?? 'HilDes',
        'ogImage' => $seo?->og_image,
        'twitterCard' => $seo?->twitter_card ?? 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->meta_title ?? null),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->meta_description ?? null),
        'twitterImage' => $seo?->twitter_image,
        'schemaJson' => $seo?->schema_json,
    ]);
})->name('about');

Route::get('/faqs', function () {
    $faqPage = CmsPage::query()
        ->where('slug', 'faqs')
        ->where('is_published', true)
        ->with('seoMeta')
        ->first();
    abort_unless($faqPage, 404);

    $seo = $faqPage->seoMeta;
    $faqDetailHtml = (string) ($faqPage->detail_content ?? '');
    $faqNormalItems = collect($faqPage->faqs_json ?? [])
        ->map(function ($item) {
            return [
                'title' => trim((string) data_get($item, 'title', '')),
                'detail' => trim((string) data_get($item, 'detail', '')),
            ];
        })
        ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
        ->values();
    $faqGroups = collect($faqPage->faq_groups_json ?? [])
        ->map(function ($group) {
            $items = collect(data_get($group, 'items', []))
                ->map(function ($item) {
                    return [
                        'title' => trim((string) data_get($item, 'title', '')),
                        'detail' => trim((string) data_get($item, 'detail', '')),
                    ];
                })
                ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
                ->values();

            return [
                'category' => trim((string) data_get($group, 'category', '')),
                'items' => $items,
            ];
        })
        ->filter(fn ($group) => $group['category'] !== '' && $group['items']->isNotEmpty())
        ->values();

    return view('frontend.faqs', [
        'faqBannerImageUrl' => $faqPage->banner_image_url,
        'faqBannerImageAlt' => $faqPage->banner_image_alt ?: 'HilDes FAQs',
        'faqDetailHtml' => $faqDetailHtml,
        'faqGroups' => $faqGroups,
        'faqNormalItems' => $faqNormalItems,
        'metaTitle' => $seo?->meta_title ?? 'FAQs | HilDes',
        'metaDescription' => $seo?->meta_description ?? 'Frequently asked questions about HilDes services.',
        'metaKeywords' => $seo?->meta_keywords ?? 'hildes faqs, software development faq',
        'metaRobots' => $seo?->robots_directive ?? 'index,follow',
        'canonicalUrl' => $seo?->canonical_url ?? url()->current(),
        'metaAuthor' => $seo?->meta_author ?? 'HilDes',
        'metaViewport' => $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0',
        'ogType' => $seo?->og_type ?? 'website',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?? null),
        'ogDescription' => $seo?->og_description ?: ($seo?->meta_description ?? null),
        'ogUrl' => $seo?->og_url ?: ($seo?->canonical_url ?? url()->current()),
        'ogSiteName' => $seo?->og_site_name ?? 'HilDes',
        'ogImage' => $seo?->og_image,
        'twitterCard' => $seo?->twitter_card ?? 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->meta_title ?? null),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->meta_description ?? null),
        'twitterImage' => $seo?->twitter_image,
        'schemaJson' => $seo?->schema_json,
    ]);
})->name('faqs.page');

Route::get('/why-us', fn () => $renderCmsSimplePage(
    'why-us',
    'Why HilDes',
    'Why Us',
    'Why Choose <br> HilDes.'
))->name('why-us.page');

Route::get('/terms-and-conditions', fn () => $renderCmsSimplePage(
    'terms-and-conditions',
    'Legal',
    'Terms',
    'Terms and <br> Conditions.'
))->name('terms.page');

Route::get('/privacy-policy', fn () => $renderCmsSimplePage(
    'privacy-policy',
    'Privacy',
    'Policy',
    'Privacy <br> Policy.'
))->name('privacy.page');

Route::get('/sla', fn () => $renderCmsSimplePage(
    'sla',
    'Service Level',
    'SLA',
    'Service Level <br> Agreement.'
))->name('sla.page');

Route::get('/contact-us', function () {
    $contactPage = CmsPage::query()
        ->where('slug', 'contact-us')
        ->where('is_published', true)
        ->with('seoMeta')
        ->first();
    $seo = $contactPage?->seoMeta;
    $contactCmsFaqs = collect($contactPage?->faqs_json ?? [])
        ->map(function ($item) {
            return [
                'title' => trim((string) data_get($item, 'title', '')),
                'detail' => trim((string) data_get($item, 'detail', '')),
            ];
        })
        ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
        ->values();

    return view('frontend.contact', [
        'contactCmsFaqs' => $contactCmsFaqs,
        'metaTitle' => $seo?->meta_title ?? 'Contact Us | HilDes',
        'metaDescription' => $seo?->meta_description ?? 'Contact HilDes for AI, SaaS, MVP, web, mobile, and DevOps project consultation.',
        'metaKeywords' => $seo?->meta_keywords ?? 'contact hildes, ai saas consultation, mvp project inquiry',
        'metaRobots' => $seo?->robots_directive ?? 'index,follow',
        'canonicalUrl' => $seo?->canonical_url ?? url()->current(),
        'metaAuthor' => $seo?->meta_author ?? 'HilDes',
        'metaViewport' => $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0',
        'ogType' => $seo?->og_type ?? 'website',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?? null),
        'ogDescription' => $seo?->og_description ?: ($seo?->meta_description ?? null),
        'ogUrl' => $seo?->og_url ?: ($seo?->canonical_url ?? url()->current()),
        'ogSiteName' => $seo?->og_site_name ?? 'HilDes',
        'ogImage' => $seo?->og_image,
        'twitterCard' => $seo?->twitter_card ?? 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->meta_title ?? null),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->meta_description ?? null),
        'twitterImage' => $seo?->twitter_image,
        'schemaJson' => $seo?->schema_json,
    ]);
})->name('contact');

Route::get('/get-a-quote', function () {
    $quotePage = CmsPage::query()
        ->where('slug', 'get-a-quote')
        ->where('is_published', true)
        ->with('seoMeta')
        ->first();
    $seo = $quotePage?->seoMeta;
    $quoteCmsFaqs = collect($quotePage?->faqs_json ?? [])
        ->map(function ($item) {
            return [
                'title' => trim((string) data_get($item, 'title', '')),
                'detail' => trim((string) data_get($item, 'detail', '')),
            ];
        })
        ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
        ->values();

    return view('frontend.quote', [
        'quoteCmsFaqs' => $quoteCmsFaqs,
        'metaTitle' => $seo?->meta_title ?? 'Get a Quote | HilDes',
        'metaDescription' => $seo?->meta_description ?? 'Request a project quote from HilDes for AI, SaaS, MVP, web, mobile, and DevOps services.',
        'metaKeywords' => $seo?->meta_keywords ?? 'get a quote hildes, project estimate, ai saas mvp quote',
        'metaRobots' => $seo?->robots_directive ?? 'index,follow',
        'canonicalUrl' => $seo?->canonical_url ?? url()->current(),
        'metaAuthor' => $seo?->meta_author ?? 'HilDes',
        'metaViewport' => $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0',
        'ogType' => $seo?->og_type ?? 'website',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?? null),
        'ogDescription' => $seo?->og_description ?: ($seo?->meta_description ?? null),
        'ogUrl' => $seo?->og_url ?: ($seo?->canonical_url ?? url()->current()),
        'ogSiteName' => $seo?->og_site_name ?? 'HilDes',
        'ogImage' => $seo?->og_image,
        'twitterCard' => $seo?->twitter_card ?? 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->meta_title ?? null),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->meta_description ?? null),
        'twitterImage' => $seo?->twitter_image,
        'schemaJson' => $seo?->schema_json,
    ]);
})->name('quote');

Route::get('/careers', function () {
    $careersPage = CmsPage::query()
        ->where('slug', 'careers')
        ->where('is_published', true)
        ->with('seoMeta')
        ->first();
    abort_unless($careersPage, 404);

    $seo = $careersPage->seoMeta;
    $careersCmsFaqs = collect($careersPage->faqs_json ?? [])
        ->map(function ($item) {
            return [
                'title' => trim((string) data_get($item, 'title', '')),
                'detail' => trim((string) data_get($item, 'detail', '')),
            ];
        })
        ->filter(fn ($item) => $item['title'] !== '' && $item['detail'] !== '')
        ->values();

    $openJobs = Job::query()
        ->where('status', 'open')
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->get();

    return view('frontend.careers', [
        'careersPage' => $careersPage,
        'careersCmsDetail' => $careersPage->detail_content,
        'careersCmsFaqs' => $careersCmsFaqs,
        'openJobs' => $openJobs,
        'metaTitle' => $seo?->meta_title ?? ($careersPage->title.' | HilDes'),
        'metaDescription' => $seo?->meta_description ?? \Illuminate\Support\Str::limit(strip_tags((string) $careersPage->detail_content), 160),
        'metaKeywords' => $seo?->meta_keywords ?? 'careers HilDes, software jobs, internship',
        'metaRobots' => $seo?->robots_directive ?? 'index,follow',
        'canonicalUrl' => $seo?->canonical_url ?? url()->current(),
        'metaAuthor' => $seo?->meta_author ?? 'HilDes',
        'metaViewport' => $seo?->meta_viewport ?? 'width=device-width, initial-scale=1.0',
        'ogType' => $seo?->og_type ?? 'website',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?? null),
        'ogDescription' => $seo?->og_description ?: ($seo?->meta_description ?? null),
        'ogUrl' => $seo?->og_url ?: ($seo?->canonical_url ?? url()->current()),
        'ogSiteName' => $seo?->og_site_name ?? 'HilDes',
        'ogImage' => $seo?->og_image,
        'twitterCard' => $seo?->twitter_card ?? 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->meta_title ?? null),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->meta_description ?? null),
        'twitterImage' => $seo?->twitter_image,
        'schemaJson' => $seo?->schema_json,
    ]);
})->name('careers.page');

Route::get('/careers/{job:slug}', [CareerJobController::class, 'show'])->name('careers.job.show');
Route::post('/careers/{job:slug}/apply', [CareerJobController::class, 'apply'])
    ->middleware('throttle:15,1')
    ->name('careers.job.apply');

Route::get('/{slug}', function (string $slug) {
    $service = ServicePage::query()
        ->with('seoMeta')
        ->where('is_published', true)
        ->where('slug', $slug)
        ->firstOrFail();

    $seo = $service->seoMeta;
    $metaDescription = $seo?->meta_description ?: strip_tags((string) $service->hero_content);
    $canonicalUrl = $seo?->canonical_url ?: url()->current();
    $ogImage = $seo?->og_image ?: ($service->hero_image_url ?: null);
    $twitterImage = $seo?->twitter_image ?: $ogImage;
    $robotsDirective = $seo?->robots_directive ?: (($seo && ! $seo->is_indexable) ? 'noindex,nofollow' : 'index,follow');

    return view('frontend.service-details', [
        'service' => $service,
        'services' => ServicePage::query()->where('is_published', true)->ordered()->get(['id', 'name', 'slug']),
        'sidebarRemainingServices' => ServicePage::query()
            ->where('is_published', true)
            ->where('id', '!=', $service->id)
            ->ordered()
            ->get(['id', 'name', 'slug']),
        'sidebarCaseStudies' => CaseStudy::query()
            ->where('is_published', true)
            ->ordered()
            ->get(['id', 'title', 'slug']),
        'metaTitle' => $seo?->meta_title ?: $service->name,
        'metaDescription' => $metaDescription,
        'metaKeywords' => $seo?->meta_keywords ?: 'services, technology, hildes',
        'metaRobots' => $robotsDirective,
        'canonicalUrl' => $canonicalUrl,
        'ogType' => 'website',
        'ogTitle' => $seo?->og_title ?: ($seo?->meta_title ?: $service->name),
        'ogDescription' => $seo?->og_description ?: $metaDescription,
        'ogUrl' => $canonicalUrl,
        'ogImage' => $ogImage,
        'twitterCard' => 'summary_large_image',
        'twitterTitle' => $seo?->twitter_title ?: ($seo?->og_title ?: ($seo?->meta_title ?: $service->name)),
        'twitterDescription' => $seo?->twitter_description ?: ($seo?->og_description ?: $metaDescription),
        'twitterImage' => $twitterImage,
        'schemaJson' => $seo?->schema_json,
    ]);
})->where('slug', '^(?!admin$|login$|logout$)[A-Za-z0-9\-]+$')->name('service.slug');
