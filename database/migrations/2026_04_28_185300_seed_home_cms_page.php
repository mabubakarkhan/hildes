<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'home';

        $existing = DB::table('cms_pages')->where('slug', $slug)->first();
        if ($existing) {
            return;
        }

        $faqs = [
            ['title' => 'What services does HilDes provide?', 'detail' => 'HilDes provides AI development, SaaS platform development, MVP development, and custom software solutions.'],
            ['title' => 'Who are your ideal clients?', 'detail' => 'HilDes works with startups, growing businesses, and enterprises.'],
            ['title' => 'Do you offer MVP development?', 'detail' => 'Yes, HilDes helps startups build MVPs quickly.'],
            ['title' => 'Can you scale applications?', 'detail' => 'Yes, HilDes builds scalable systems designed for growth.'],
            ['title' => 'How can I get started?', 'detail' => 'You can contact HilDes through the website to discuss your project.'],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'HilDes',
            'slug' => $slug,
            'detail_content' => null,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 6,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    'name' => 'HilDes',
                    'url' => 'https://www.hildes.io/',
                    'logo' => 'https://www.hildes.io/logo.png',
                    'description' => 'HilDes is a software development company specializing in AI solutions, SaaS platforms, and custom web and mobile applications.',
                    'sameAs' => [
                        'https://www.linkedin.com/company/hildes',
                        'https://www.facebook.com/hildes',
                    ],
                    'contactPoint' => [
                        '@type' => 'ContactPoint',
                        'contactType' => 'sales',
                        'email' => 'contact@hildes.io',
                    ],
                    'areaServed' => 'Worldwide',
                    'hasOfferCatalog' => [
                        '@type' => 'OfferCatalog',
                        'name' => 'Software Development Services',
                        'itemListElement' => [
                            [
                                '@type' => 'Offer',
                                'itemOffered' => [
                                    '@type' => 'Service',
                                    'name' => 'AI Development',
                                    'description' => 'AI-powered solutions including automation and intelligent systems.',
                                ],
                            ],
                            [
                                '@type' => 'Offer',
                                'itemOffered' => [
                                    '@type' => 'Service',
                                    'name' => 'SaaS Development',
                                    'description' => 'Scalable SaaS platforms with multi-tenant architecture.',
                                ],
                            ],
                            [
                                '@type' => 'Offer',
                                'itemOffered' => [
                                    '@type' => 'Service',
                                    'name' => 'MVP Development',
                                    'description' => 'Rapid MVP development for startups.',
                                ],
                            ],
                            [
                                '@type' => 'Offer',
                                'itemOffered' => [
                                    '@type' => 'Service',
                                    'name' => 'Custom Software Development',
                                    'description' => 'Tailored software solutions for businesses.',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    '@type' => 'FAQPage',
                    'faq_schema_version' => 1,
                    'mainEntity' => array_map(static fn ($faq) => [
                        '@type' => 'Question',
                        'name' => $faq['title'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq['detail'],
                        ],
                    ], $faqs),
                ],
            ],
        ];

        DB::table('seo_metas')->insert([
            'seoable_type' => 'App\Models\CmsPage',
            'seoable_id' => $pageId,
            'seo_enabled' => true,
            'is_indexable' => true,
            'include_in_sitemap' => true,
            'slug' => '',
            'canonical_url' => 'https://www.hildes.io/',
            'meta_title' => 'HilDes | AI, SaaS & Custom Software Development Company',
            'meta_description' => 'HilDes is a software development company specializing in AI solutions, SaaS platforms, and custom web & mobile applications. Build, scale, and innovate with us.',
            'meta_keywords' => 'AI development company, SaaS development, custom software development, web development agency, mobile app development, MVP development',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'AI development company',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'HilDes | AI, SaaS & Software Development Experts',
            'og_description' => 'We build scalable AI systems, SaaS platforms, and custom applications for startups and enterprises.',
            'og_url' => 'https://www.hildes.io/',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'HilDes | AI & SaaS Development Company',
            'twitter_description' => 'Build scalable AI, SaaS, and custom software solutions with HilDes.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'home')->first();
        if (! $page) {
            return;
        }

        DB::table('seo_metas')
            ->where('seoable_type', 'App\Models\CmsPage')
            ->where('seoable_id', $page->id)
            ->delete();

        DB::table('cms_pages')->where('id', $page->id)->delete();
    }
};
