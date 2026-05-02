<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'services';

        $existing = DB::table('cms_pages')->where('slug', $slug)->first();
        if ($existing) {
            return;
        }

        $detail = <<<'HTML'
<h2>Software Development Services</h2>
<p>HilDes offers a full range of modern software development services designed to help businesses build, scale, and innovate with confidence. From AI systems to SaaS platforms, we deliver solutions tailored to real business needs.</p>

<h3>Our Core Services</h3>
<p>We specialize in building high-performance digital products across multiple domains:</p>

<h4>AI Development Services</h4>
<p>We build intelligent systems that help businesses automate processes, analyze data, and improve decision-making.</p>
<ul>
<li>RAG-based AI systems</li>
<li>Automation workflows</li>
<li>AI-powered applications</li>
<li>Data-driven solutions</li>
</ul>

<h4>SaaS Development Services</h4>
<p>We design and develop scalable SaaS platforms built for long-term growth and multi-user environments.</p>
<ul>
<li>Multi-tenant architecture</li>
<li>Subscription & billing systems</li>
<li>Admin dashboards</li>
<li>Cloud-native solutions</li>
</ul>

<h4>MVP Development Services</h4>
<p>We help startups turn ideas into market-ready products quickly and efficiently.</p>
<ul>
<li>Rapid prototyping</li>
<li>Lean MVP development</li>
<li>Product validation</li>
<li>Startup-ready architecture</li>
</ul>

<h4>Custom Software Development</h4>
<p>We build tailored software solutions designed around your business processes and goals.</p>
<ul>
<li>Enterprise applications</li>
<li>Workflow automation systems</li>
<li>Internal tools</li>
<li>Business-specific platforms</li>
</ul>

<h4>Web Development Services</h4>
<p>We create fast, responsive, and scalable web applications using modern frameworks.</p>
<ul>
<li>Next.js / React applications</li>
<li>High-performance websites</li>
<li>API-driven architectures</li>
<li>SEO-optimized builds</li>
</ul>

<h4>Mobile App Development</h4>
<p>We develop cross-platform and native mobile applications for seamless user experiences.</p>
<ul>
<li>iOS & Android apps</li>
<li>Flutter / React Native solutions</li>
<li>Scalable backend integration</li>
<li>Performance optimization</li>
</ul>

<h3>Our Approach</h3>
<p>We follow a structured development process to ensure quality and scalability:</p>
<ul>
<li>Requirement Analysis</li>
<li>System Design & Architecture</li>
<li>Agile Development</li>
<li>Testing & Deployment</li>
<li>Scaling & Support</li>
</ul>

<h3>Why Choose HilDes Services</h3>
<ul>
<li>Business-focused engineering approach</li>
<li>Scalable and future-proof architecture</li>
<li>Fast and agile delivery cycles</li>
<li>Clean and maintainable codebase</li>
<li>Long-term technical partnership</li>
</ul>

<h3>Industries We Work With</h3>
<p>We provide solutions across multiple industries including:</p>
<ul>
<li>SaaS startups</li>
<li>E-commerce businesses</li>
<li>Enterprises</li>
<li>Tech startups</li>
<li>AI-driven platforms</li>
</ul>
HTML;

        $faqs = [
            ['title' => 'What services does HilDes offer?', 'detail' => 'HilDes offers AI development, SaaS development, MVP development, custom software, web, and mobile app development.'],
            ['title' => 'Do you build SaaS products from scratch?', 'detail' => 'Yes, we design and develop full SaaS platforms including backend, frontend, and infrastructure.'],
            ['title' => 'Can you help startups build MVPs?', 'detail' => 'Yes, we specialize in building fast, scalable MVPs for startups.'],
            ['title' => 'Do you provide AI development services?', 'detail' => 'Yes, we build AI-powered systems including automation and RAG-based solutions.'],
            ['title' => 'Do you offer long-term support?', 'detail' => 'Yes, we provide maintenance, scaling, and post-launch support.'],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'Software Development Services',
            'slug' => $slug,
            'detail_content' => $detail,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 7,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    'name' => 'Software Development Services | HilDes',
                    'url' => 'https://www.hildes.io/services',
                    'description' => 'Complete software development services including AI, SaaS, MVP, web and mobile app development by HilDes.',
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'HilDes',
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => 'https://www.hildes.io/logo.png',
                        ],
                    ],
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'name' => 'HilDes Services',
                        'itemListElement' => [
                            ['@type' => 'ListItem', 'position' => 1, 'name' => 'AI Development Services'],
                            ['@type' => 'ListItem', 'position' => 2, 'name' => 'SaaS Development Services'],
                            ['@type' => 'ListItem', 'position' => 3, 'name' => 'MVP Development Services'],
                            ['@type' => 'ListItem', 'position' => 4, 'name' => 'Custom Software Development'],
                            ['@type' => 'ListItem', 'position' => 5, 'name' => 'Web Development Services'],
                            ['@type' => 'ListItem', 'position' => 6, 'name' => 'Mobile App Development'],
                        ],
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
            'slug' => $slug,
            'canonical_url' => 'https://www.hildes.io/services',
            'meta_title' => 'Software Development Services | AI, SaaS & Custom Solutions | HilDes',
            'meta_description' => 'Explore all software development services by HilDes including AI development, SaaS platforms, MVP development, and custom web & mobile applications.',
            'meta_keywords' => 'software development services, AI development services, SaaS development company, MVP development, custom software services, web development agency',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'software development services',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'Software Development Services | HilDes',
            'og_description' => 'Discover AI, SaaS, MVP, and custom software development services offered by HilDes.',
            'og_url' => 'https://www.hildes.io/services',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'HilDes Software Development Services',
            'twitter_description' => 'AI, SaaS, MVP, and custom software development services for startups and enterprises.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'services')->first();
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
