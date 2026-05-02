<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'why-us';

        $existing = DB::table('cms_pages')->where('slug', $slug)->first();
        if ($existing) {
            return;
        }

        $detail = <<<'HTML'
<h2>Why Choose HilDes</h2>
<p>Choosing the right technology partner can define the success of your product. At HilDes, we go beyond development — we focus on delivering scalable, reliable, and business-driven software solutions that create real impact.</p>

<h3>Business-Focused Development</h3>
<p>We do not just write code — we solve business problems. Every solution we build is aligned with your goals, whether it is increasing revenue, improving efficiency, or accelerating growth.</p>

<h3>Expertise in AI, SaaS & Custom Software</h3>
<p>HilDes specializes in high-demand, high-impact technologies:</p>
<ul>
<li><strong>AI Development</strong> – Intelligent systems, automation, and data-driven applications</li>
<li><strong>SaaS Platforms</strong> – Scalable, multi-tenant solutions designed for growth</li>
<li><strong>Custom Software</strong> – Tailored applications built around your workflows</li>
</ul>
<p>This focused expertise ensures you get solutions that are modern, competitive, and future-ready.</p>

<h3>Scalable Architecture from Day One</h3>
<p>We design systems that grow with your business. Whether you are launching an MVP or scaling to thousands of users, our architecture ensures performance, reliability, and flexibility.</p>

<h3>Fast and Agile Execution</h3>
<p>Speed matters in today’s market. Our agile development approach allows us to:</p>
<ul>
<li>Deliver faster iterations</li>
<li>Adapt to changing requirements</li>
<li>Maintain high-quality standards</li>
</ul>
<p>You get a product that evolves quickly without compromising stability.</p>

<h3>Clean, Maintainable Code</h3>
<p>We follow best practices to ensure your codebase is:</p>
<ul>
<li>Easy to scale and maintain</li>
<li>Well-structured and documented</li>
<li>Built for long-term sustainability</li>
</ul>
<p>This reduces technical debt and future development costs.</p>

<h3>Transparent Communication</h3>
<p>We believe in clear and consistent communication:</p>
<ul>
<li>Regular updates and progress tracking</li>
<li>Direct collaboration with developers</li>
<li>Full visibility into project status</li>
</ul>
<p>No confusion, no hidden surprises.</p>

<h3>Long-Term Partnership</h3>
<p>We aim to be more than a service provider — we become your technology partner. From initial idea to scaling and optimization, we support your product at every stage.</p>

<h3>Proven Development Process</h3>
<p>Our structured approach ensures reliable delivery:</p>
<ul>
<li>Discovery & Planning</li>
<li>System Design</li>
<li>Agile Development</li>
<li>Deployment & Scaling</li>
</ul>
<p>This minimizes risks and ensures predictable outcomes.</p>

<h3>Focus on Performance & Reliability</h3>
<p>We build systems that are:</p>
<ul>
<li>Fast and responsive</li>
<li>Secure and stable</li>
<li>Optimized for real-world usage</li>
</ul>
<p>Your users get a seamless experience, and your business gets consistent performance.</p>

<h3>Work With Confidence</h3>
<p>When you choose HilDes, you are choosing a partner committed to delivering quality, scalability, and measurable results.</p>
HTML;

        $faqs = [
            ['title' => 'What makes HilDes different from other software companies?', 'detail' => 'HilDes focuses on business outcomes, scalable architecture, and modern technologies like AI and SaaS.'],
            ['title' => 'Do you work with startups and enterprises?', 'detail' => 'Yes, we work with both startups and established enterprises.'],
            ['title' => 'How do you ensure project success?', 'detail' => 'We follow a structured process, maintain clear communication, and build scalable solutions.'],
            ['title' => 'Can you scale my product as it grows?', 'detail' => 'Yes, all systems are designed with scalability in mind.'],
            ['title' => 'Do you provide long-term support?', 'detail' => 'Yes, we offer ongoing support and maintenance after project delivery.'],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'Why Choose HilDes',
            'slug' => $slug,
            'detail_content' => $detail,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 5,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebPage',
                    'name' => 'Why Choose HilDes',
                    'url' => 'https://www.hildes.io/why-us',
                    'description' => 'Reasons to choose HilDes for AI, SaaS, and custom software development services.',
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'HilDes',
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => 'https://www.hildes.io/logo.png',
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
            'slug' => $slug,
            'canonical_url' => 'https://www.hildes.io/why-us',
            'meta_title' => 'Why Choose HilDes | AI, SaaS & Software Development Experts',
            'meta_description' => 'Discover why businesses choose HilDes for AI development, SaaS platforms, and custom software solutions. We deliver scalable, high-performance digital products.',
            'meta_keywords' => 'why choose HilDes, software development company benefits, AI development experts, SaaS development company, custom software company',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'why choose HilDes',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'Why Choose HilDes | Software Development Experts',
            'og_description' => 'Learn what makes HilDes a trusted partner for AI, SaaS, and custom software development.',
            'og_url' => 'https://www.hildes.io/why-us',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Why Choose HilDes',
            'twitter_description' => 'Explore the key reasons businesses trust HilDes for scalable software solutions.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'why-us')->first();
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
