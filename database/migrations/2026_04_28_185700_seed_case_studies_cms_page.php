<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'case-studies';

        $existing = DB::table('cms_pages')->where('slug', $slug)->first();
        if ($existing) {
            return;
        }

        $detail = <<<'HTML'
<h2>Case Studies</h2>
<p>At HilDes, we do not just build software — we deliver real-world solutions that solve business problems and create measurable impact. Our case studies highlight how we help startups and enterprises turn ideas into scalable digital products.</p>

<h3>What You Will Find Here</h3>
<p>Our case studies showcase:</p>
<ul>
<li>AI-powered applications and automation systems</li>
<li>Scalable SaaS platforms built for growth</li>
<li>MVPs that helped startups validate ideas quickly</li>
<li>Custom software tailored to business needs</li>
<li>Web and mobile applications with real users</li>
</ul>

<h3>Our Approach in Real Projects</h3>
<p>Each case study reflects our structured development approach:</p>
<ul>
<li>Understanding business challenges</li>
<li>Designing scalable architecture</li>
<li>Building with agile execution</li>
<li>Deploying production-ready systems</li>
<li>Optimizing for performance and growth</li>
</ul>

<h3>Why Our Case Studies Matter</h3>
<p>They demonstrate:</p>
<ul>
<li>Real business impact, not just technical output</li>
<li>Scalable architecture decisions</li>
<li>Problem-solving approach</li>
<li>Measurable improvements in performance or efficiency</li>
<li>Long-term product success</li>
</ul>

<h3>Industries We Have Worked With</h3>
<p>Our work spans multiple industries, including:</p>
<ul>
<li>SaaS startups</li>
<li>E-commerce platforms</li>
<li>Enterprise systems</li>
<li>AI-driven products</li>
<li>Service-based businesses</li>
</ul>

<h3>Learn From Real Projects</h3>
<p>Each case study helps you understand:</p>
<ul>
<li>How complex problems are solved using technology</li>
<li>Why certain architectural decisions are made</li>
<li>How scalable systems are built from scratch</li>
<li>What results can be achieved with proper execution</li>
</ul>

<h3>Build Your Next Project With Us</h3>
<p>If you are inspired by our work, we can help you build your own product — from MVP to enterprise-scale systems.</p>
HTML;

        $faqs = [
            ['title' => 'What type of projects are included in case studies?', 'detail' => 'We include AI, SaaS, MVP, web, mobile, and custom software projects.'],
            ['title' => 'Do your case studies show real client work?', 'detail' => 'Yes, they are based on real-world projects delivered by HilDes.'],
            ['title' => 'Can I request a similar solution for my business?', 'detail' => 'Yes, we can build custom solutions based on your requirements.'],
            ['title' => 'Do you share technical details in case studies?', 'detail' => 'Yes, we highlight architecture, approach, and outcomes where applicable.'],
            ['title' => 'Are case studies updated regularly?', 'detail' => 'Yes, we continuously add new projects as they are completed.'],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'Case Studies',
            'slug' => $slug,
            'detail_content' => $detail,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 8,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    'name' => 'Case Studies | HilDes',
                    'url' => 'https://www.hildes.io/case-studies',
                    'description' => 'Explore real-world AI, SaaS, MVP, and custom software development case studies by HilDes.',
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
                        'name' => 'HilDes Case Studies',
                        'itemListElement' => [
                            ['@type' => 'ListItem', 'position' => 1, 'name' => 'AI Development Case Studies'],
                            ['@type' => 'ListItem', 'position' => 2, 'name' => 'SaaS Platform Case Studies'],
                            ['@type' => 'ListItem', 'position' => 3, 'name' => 'MVP Development Case Studies'],
                            ['@type' => 'ListItem', 'position' => 4, 'name' => 'Custom Software Projects'],
                            ['@type' => 'ListItem', 'position' => 5, 'name' => 'Web & Mobile App Case Studies'],
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
            'canonical_url' => 'https://www.hildes.io/case-studies',
            'meta_title' => 'Case Studies | AI, SaaS & Software Projects | HilDes',
            'meta_description' => 'Explore HilDes case studies showcasing real-world AI, SaaS, MVP, and custom software projects. See how we help businesses build scalable digital products.',
            'meta_keywords' => 'software case studies, AI case studies, SaaS projects, MVP case studies, custom software portfolio, development success stories',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'software case studies',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'Case Studies | HilDes Software Projects',
            'og_description' => 'Discover real-world AI, SaaS, MVP, and custom software development success stories by HilDes.',
            'og_url' => 'https://www.hildes.io/case-studies',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'HilDes Case Studies',
            'twitter_description' => 'Explore real software projects built by HilDes including AI, SaaS, and MVP solutions.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'case-studies')->first();
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
