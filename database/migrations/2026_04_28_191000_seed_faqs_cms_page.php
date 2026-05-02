<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'faqs';

        if (DB::table('cms_pages')->where('slug', $slug)->exists()) {
            return;
        }

        $detail = <<<'HTML'
<h2>Frequently Asked Questions</h2>
<p>This page answers the most common questions about our services, process, pricing, and technical capabilities. If you need more details, feel free to contact our team.</p>
HTML;

        $faqGroups = [
            [
                'category' => 'General Questions',
                'items' => [
                    ['title' => 'What does HilDes do?', 'detail' => 'HilDes is a software development company specializing in AI solutions, SaaS platforms, MVP development, and custom web and mobile applications.'],
                    ['title' => 'Who do you work with?', 'detail' => 'We work with startups, growing businesses, and enterprises looking to build or scale digital products.'],
                ],
            ],
            [
                'category' => 'Services & Expertise',
                'items' => [
                    ['title' => 'Do you build AI-powered applications?', 'detail' => 'Yes, we develop AI systems including RAG-based solutions, automation tools, and intelligent workflows.'],
                    ['title' => 'Can you build a SaaS product from scratch?', 'detail' => 'Yes, we design and develop scalable SaaS platforms, including multi-tenant architecture and subscription systems.'],
                    ['title' => 'Do you offer MVP development?', 'detail' => 'Yes, we help startups quickly build MVPs to validate ideas and enter the market faster.'],
                ],
            ],
            [
                'category' => 'Process & Timeline',
                'items' => [
                    ['title' => 'How long does a project take?', 'detail' => 'Project timelines depend on complexity. MVPs typically take 4–8 weeks, while larger systems may take several months.'],
                    ['title' => 'What development process do you follow?', 'detail' => 'We follow an agile methodology with iterative development, regular updates, and continuous feedback.'],
                ],
            ],
            [
                'category' => 'Pricing & Engagement',
                'items' => [
                    ['title' => 'How much does a project cost?', 'detail' => 'Costs vary depending on scope, features, and complexity. We provide custom quotes after understanding your requirements.'],
                    ['title' => 'Do you offer fixed pricing or hourly models?', 'detail' => 'We offer both fixed-price and flexible engagement models depending on the project.'],
                ],
            ],
            [
                'category' => 'Support & Maintenance',
                'items' => [
                    ['title' => 'Do you provide post-launch support?', 'detail' => 'Yes, we offer maintenance, updates, and scaling support after deployment.'],
                    ['title' => 'Do you provide SLA-based support?', 'detail' => 'Yes, we provide SLA-based support with defined uptime and response times.'],
                ],
            ],
            [
                'category' => 'Technical Questions',
                'items' => [
                    ['title' => 'What technologies do you use?', 'detail' => 'We use modern technologies such as React.js, Next.js, Node.js, Fastify, MongoDB, and AI frameworks.'],
                    ['title' => 'Can you scale applications as traffic grows?', 'detail' => 'Yes, we design systems with scalability in mind to handle increasing users and data loads.'],
                ],
            ],
            [
                'category' => 'Security & Data',
                'items' => [
                    ['title' => 'How do you ensure data security?', 'detail' => 'We follow best practices including secure coding, encryption, and access control.'],
                    ['title' => 'Do you sign NDAs?', 'detail' => 'Yes, we can sign NDAs to protect your business ideas and data.'],
                ],
            ],
            [
                'category' => 'Getting Started',
                'items' => [
                    ['title' => 'How can I start a project with HilDes?', 'detail' => 'You can contact us via our website or email to discuss your requirements and get a proposal.'],
                    ['title' => 'Do you provide consultation?', 'detail' => 'Yes, we offer consultation to help you plan and define your project.'],
                ],
            ],
        ];

        $faqs = [
            ['title' => 'What services does HilDes provide?', 'detail' => 'HilDes provides AI development, SaaS platforms, MVP development, and custom software solutions.'],
            ['title' => 'How long does it take to build an MVP?', 'detail' => 'Typically, MVP development takes between 4 to 8 weeks depending on complexity.'],
            ['title' => 'Do you provide ongoing support?', 'detail' => 'Yes, we offer post-launch support and SLA-based maintenance services.'],
            ['title' => 'What industries do you work with?', 'detail' => 'We work across multiple industries including startups, SaaS businesses, and enterprises.'],
            ['title' => 'How do I get started?', 'detail' => 'You can contact HilDes through the website to discuss your project and receive a proposal.'],
        ];

        $allQuestions = collect($faqs)
            ->concat(collect($faqGroups)->flatMap(fn ($group) => $group['items']))
            ->unique(fn ($item) => md5($item['title'].'|'.$item['detail']))
            ->values()
            ->all();

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'FAQPage',
                    'name' => 'FAQs | HilDes',
                    'url' => 'https://www.hildes.io/faqs',
                    'description' => 'Frequently asked questions about HilDes services, pricing, timelines, and technical expertise.',
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'HilDes',
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => 'https://www.hildes.io/logo.png',
                        ],
                    ],
                    'faq_schema_version' => 1,
                    'mainEntity' => array_map(static fn ($faq) => [
                        '@type' => 'Question',
                        'name' => $faq['title'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $faq['detail'],
                        ],
                    ], $allQuestions),
                    'hasPart' => array_map(static fn ($group) => [
                        '@type' => 'FAQPage',
                        'name' => $group['category'],
                        'mainEntity' => array_map(static fn ($faq) => [
                            '@type' => 'Question',
                            'name' => $faq['title'],
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => $faq['detail'],
                            ],
                        ], $group['items']),
                    ], $faqGroups),
                ],
            ],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'FAQs',
            'slug' => $slug,
            'detail_content' => $detail,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_groups_json' => json_encode($faqGroups, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 9,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('seo_metas')->insert([
            'seoable_type' => 'App\Models\CmsPage',
            'seoable_id' => $pageId,
            'seo_enabled' => true,
            'is_indexable' => true,
            'include_in_sitemap' => true,
            'slug' => 'faqs',
            'canonical_url' => 'https://www.hildes.io/faqs',
            'meta_title' => 'FAQs | HilDes – AI, SaaS & Software Development Questions',
            'meta_description' => 'Find answers to common questions about HilDes services including AI development, SaaS platforms, MVP development, pricing, timelines, and support.',
            'meta_keywords' => 'HilDes FAQs, software development questions, AI development FAQ, SaaS development FAQ, MVP development questions, pricing software development',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'HilDes FAQs',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'FAQs | HilDes – Software Development Questions Answered',
            'og_description' => 'Explore frequently asked questions about AI, SaaS, and custom software development services at HilDes.',
            'og_url' => 'https://www.hildes.io/faqs',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'FAQs | HilDes',
            'twitter_description' => 'Get answers about AI development, SaaS, MVPs, pricing, and timelines.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'faqs')->first();
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
