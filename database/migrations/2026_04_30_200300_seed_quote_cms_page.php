<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'get-a-quote';

        if (DB::table('cms_pages')->where('slug', $slug)->exists()) {
            return;
        }

        $faqs = [
            [
                'title' => 'How can I request a quote from HilDes?',
                'detail' => 'You can fill out the quote request form with your project details, and our team will get back to you.',
            ],
            [
                'title' => 'What information should I provide for an accurate quote?',
                'detail' => 'Include your project scope, features, timeline, budget range, and any technical requirements.',
            ],
            [
                'title' => 'How long does it take to receive a quote?',
                'detail' => 'We typically respond with an estimate within 24–48 hours.',
            ],
            [
                'title' => 'Is the quote free?',
                'detail' => 'Yes, requesting a quote is completely free.',
            ],
            [
                'title' => 'Do you provide fixed-price estimates?',
                'detail' => 'Yes, we provide both fixed-price and flexible pricing models based on project needs.',
            ],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'Get a Quote',
            'slug' => $slug,
            'detail_content' => null,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 11,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'ContactPage',
                    'name' => 'Get a Quote | HilDes',
                    'url' => 'https://www.hildes.io/get-a-quote',
                    'description' => 'Request a custom quote for AI, SaaS, and custom software development services from HilDes.',
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'HilDes',
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => 'https://www.hildes.io/logo.png',
                        ],
                    ],
                    'mainEntity' => [
                        '@type' => 'Organization',
                        'name' => 'HilDes',
                        'contactPoint' => [
                            '@type' => 'ContactPoint',
                            'contactType' => 'sales',
                            'email' => 'contact@hildes.io',
                            'availableLanguage' => ['English'],
                        ],
                    ],
                    'mainEntityOfPage' => [
                        '@type' => 'FAQPage',
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
            ],
        ];

        DB::table('seo_metas')->insert([
            'seoable_type' => 'App\Models\CmsPage',
            'seoable_id' => $pageId,
            'seo_enabled' => true,
            'is_indexable' => true,
            'include_in_sitemap' => true,
            'slug' => 'get-a-quote',
            'canonical_url' => 'https://www.hildes.io/get-a-quote',
            'meta_title' => 'Get a Quote | AI, SaaS & Software Development | HilDes',
            'meta_description' => 'Request a custom quote from HilDes for AI development, SaaS platforms, MVPs, and custom software solutions. Get pricing and project estimation today.',
            'meta_keywords' => 'get a quote software development, AI project quote, SaaS development pricing, MVP development cost, custom software estimate',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'get a quote software development',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'Get a Quote | HilDes Software Development',
            'og_description' => 'Request a custom quote for AI, SaaS, and software development services.',
            'og_url' => 'https://www.hildes.io/get-a-quote',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Get a Quote | HilDes',
            'twitter_description' => 'Get pricing and project estimates for AI, SaaS, and custom software solutions.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'get-a-quote')->first();
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
