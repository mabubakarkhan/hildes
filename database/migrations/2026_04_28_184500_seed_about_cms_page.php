<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'about';

        $existing = DB::table('cms_pages')->where('slug', $slug)->first();
        if ($existing) {
            return;
        }

        $detail = <<<'HTML'
<h2>About HilDes</h2>
<p>HilDes is a modern software development company dedicated to building scalable, high-performance digital products. We specialize in AI-driven solutions, SaaS platforms, and custom web and mobile applications that help businesses innovate, automate, and grow.</p>
<p>Our core focus is not just development — it is delivering solutions that solve real business problems and generate measurable results.</p>

<h3>Our Expertise</h3>
<p>At HilDes, we bring together technical excellence and strategic thinking to deliver impactful software solutions:</p>
<ul>
<li><strong>AI Development</strong><br>We build intelligent systems including RAG-based solutions, automation tools, and data-driven applications.</li>
<li><strong>SaaS Development</strong><br>From MVP to enterprise-grade platforms, we create scalable SaaS products with multi-tenant architecture.</li>
<li><strong>Custom Software Solutions</strong><br>Tailored systems designed around your business processes to improve efficiency and performance.</li>
<li><strong>Web & Mobile Applications</strong><br>Fast, responsive, and user-centric applications using modern frameworks and technologies.</li>
</ul>

<h3>Our Approach to Building Software</h3>
<p>We follow a streamlined and result-oriented process to ensure successful project delivery:</p>
<ol>
<li><strong>Discovery & Strategy</strong><br>We analyze your business model, target audience, and technical requirements.</li>
<li><strong>System Design & Architecture</strong><br>We design scalable architectures that support long-term growth.</li>
<li><strong>Agile Development</strong><br>We build iteratively with continuous feedback to ensure alignment.</li>
<li><strong>Deployment & Optimization</strong><br>We launch efficiently and continuously optimize for performance and scalability.</li>
</ol>

<h3>Why Businesses Choose HilDes</h3>
<ul>
<li>Outcome-driven development focused on ROI</li>
<li>Scalable architecture built for long-term growth</li>
<li>Clean and maintainable codebase</li>
<li>Fast turnaround with agile workflows</li>
<li>Reliable long-term technology partner</li>
</ul>

<h3>Our Vision</h3>
<p>Our vision is to empower businesses worldwide with innovative, scalable, and intelligent digital solutions that drive sustainable growth and competitive advantage.</p>

<h3>Work With Us</h3>
<p>Whether you are building an MVP, scaling your SaaS product, or integrating AI into your business, HilDes provides the expertise and execution needed to bring your ideas to life.</p>
HTML;

        $faqs = [
            ['title' => 'What services does HilDes provide?', 'detail' => 'HilDes provides AI development, SaaS platform development, custom software solutions, and web/mobile app development.'],
            ['title' => 'Do you work with startups?', 'detail' => 'Yes, we help startups build MVPs, validate ideas, and scale their products efficiently.'],
            ['title' => 'Can HilDes handle enterprise-level projects?', 'detail' => 'Yes, we design and develop scalable systems suitable for enterprise environments.'],
            ['title' => 'Do you offer post-launch support?', 'detail' => 'Yes, we provide maintenance, updates, and scaling support after deployment.'],
            ['title' => 'What technologies do you use?', 'detail' => 'We work with modern technologies like React.js, Next.js, Node.js, Fastify, MongoDB, and AI frameworks.'],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'About HilDes',
            'slug' => $slug,
            'detail_content' => $detail,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    'name' => 'HilDes',
                    'url' => 'https://www.hildes.io/about',
                    'logo' => 'https://www.hildes.io/logo.png',
                    'description' => 'HilDes is a software development company specializing in AI solutions, SaaS platforms, and custom web and mobile applications.',
                    'foundingDate' => '2024',
                    'areaServed' => 'Worldwide',
                    'contactPoint' => [
                        '@type' => 'ContactPoint',
                        'contactType' => 'sales',
                        'email' => 'contact@hildes.io',
                    ],
                    'sameAs' => [
                        'https://www.linkedin.com/company/hildes',
                        'https://www.facebook.com/hildes',
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
            'canonical_url' => 'https://www.hildes.io/about',
            'meta_title' => 'About HilDes | AI, SaaS & Custom Software Development Company',
            'meta_description' => 'Discover HilDes, a software development company specializing in AI solutions, SaaS platforms, and scalable web & mobile applications. We help businesses build and grow digital products.',
            'meta_keywords' => 'about HilDes, AI development company, SaaS development, custom software development, web development agency, mobile app development company',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'about HilDes',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'About HilDes | AI, SaaS & Software Development Experts',
            'og_description' => 'Learn how HilDes helps startups and enterprises build scalable AI, SaaS, and custom software solutions.',
            'og_url' => 'https://www.hildes.io/about',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'About HilDes | AI & SaaS Development Company',
            'twitter_description' => 'We build scalable AI systems, SaaS platforms, and custom applications for modern businesses.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'about')->first();
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
