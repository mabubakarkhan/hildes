<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'contact-us';

        $existing = DB::table('cms_pages')->where('slug', $slug)->first();
        if ($existing) {
            return;
        }

        $faqs = [
            [
                'title' => 'How can I contact HilDes?',
                'detail' => 'You can contact us through our website form or email us directly at contact@hildes.io.',
            ],
            [
                'title' => 'How quickly will I get a response?',
                'detail' => 'We typically respond within 24 hours on business days.',
            ],
            [
                'title' => 'Can I request a project quote?',
                'detail' => 'Yes, you can submit your project details to receive a custom quote.',
            ],
            [
                'title' => 'Do you offer consultations?',
                'detail' => 'Yes, we provide consultation to understand your requirements and suggest the best approach.',
            ],
            [
                'title' => 'What information should I include in my inquiry?',
                'detail' => 'Include your project idea, goals, timeline, and any technical requirements if available.',
            ],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'Contact Us',
            'slug' => $slug,
            'detail_content' => null,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 10,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'ContactPage',
                    'name' => 'Contact HilDes',
                    'url' => 'https://www.hildes.io/contact',
                    'description' => 'Contact page for HilDes to inquire about AI, SaaS, and custom software development services.',
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
            'slug' => 'contact',
            'canonical_url' => 'https://www.hildes.io/contact',
            'meta_title' => 'Contact Us | HilDes – Get in Touch for AI & Software Development',
            'meta_description' => 'Contact HilDes for AI development, SaaS platforms, MVP development, and custom software solutions. Get a quote or discuss your project today.',
            'meta_keywords' => 'contact HilDes, software development contact, AI development company contact, SaaS development inquiry, hire developers',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'contact HilDes',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'Contact HilDes | Start Your Project',
            'og_description' => 'Get in touch with HilDes to discuss AI, SaaS, and custom software development projects.',
            'og_url' => 'https://www.hildes.io/contact',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Contact HilDes',
            'twitter_description' => 'Reach out to HilDes for scalable AI and software solutions.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'contact-us')->first();
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
