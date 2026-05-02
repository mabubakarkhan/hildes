<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'careers';

        if (DB::table('cms_pages')->where('slug', $slug)->exists()) {
            return;
        }

        $faqs = [
            [
                'title' => 'What kind of roles does HilDes offer?',
                'detail' => 'HilDes offers roles in frontend, backend, full-stack development, AI engineering, mobile development, and DevOps.',
            ],
            [
                'title' => 'Do you offer remote opportunities?',
                'detail' => 'Yes, depending on the role, remote or flexible work options may be available.',
            ],
            [
                'title' => 'What technologies should I know?',
                'detail' => 'Familiarity with modern technologies like React.js, Node.js, and cloud-based systems is preferred.',
            ],
            [
                'title' => 'How can I apply?',
                'detail' => 'You can apply through the careers page or contact us with your resume and portfolio.',
            ],
            [
                'title' => 'What is the hiring process like?',
                'detail' => 'The process includes application review, technical evaluation, interviews, and final selection.',
            ],
        ];

        $detailContent = <<<'HTML'
<h2>Careers at HilDes</h2>
<p>Join HilDes and be part of a team building scalable, high-impact digital products. We work on AI solutions, SaaS platforms, and custom software systems that solve real-world problems and drive business growth.</p>

<h3>Why Work With Us</h3>
<p>We offer an environment focused on growth, innovation, and meaningful work:</p>
<ul>
  <li>Work on cutting-edge technologies (AI, SaaS, modern web stacks)</li>
  <li>Opportunity to solve real business challenges</li>
  <li>Collaborative and agile work culture</li>
  <li>Focus on learning and continuous improvement</li>
  <li>Flexible work environment</li>
</ul>

<h3>What We Look For</h3>
<p>We are always looking for talented individuals who:</p>
<ul>
  <li>Have strong problem-solving skills</li>
  <li>Write clean, scalable code</li>
  <li>Understand modern development practices</li>
  <li>Are proactive and growth-oriented</li>
  <li>Can work in a collaborative environment</li>
</ul>

<h3>Open Opportunities</h3>
<p>We hire across multiple roles, including:</p>
<ul>
  <li>Full Stack Developers</li>
  <li>Frontend Developers (React / Next.js)</li>
  <li>Backend Developers (Node.js / APIs)</li>
  <li>AI / Machine Learning Engineers</li>
  <li>Mobile App Developers</li>
  <li>DevOps Engineers</li>
</ul>

<h3>Our Hiring Process</h3>
<p>Our hiring process is designed to be efficient and transparent:</p>
<ol>
  <li>Application Review</li>
  <li>Technical Assessment or Discussion</li>
  <li>Interview (Technical + Culture Fit)</li>
  <li>Final Decision</li>
</ol>

<h3>Growth &amp; Development</h3>
<p>At HilDes, we invest in your growth:</p>
<ul>
  <li>Exposure to real-world scalable systems</li>
  <li>Opportunities to work on diverse projects</li>
  <li>Continuous learning and skill development</li>
</ul>

<h3>Work With Impact</h3>
<p>Every project you work on contributes to building products used by real businesses and users. Your work directly impacts product success and business growth.</p>

<h3>Apply Now</h3>
<p>If you’re passionate about building scalable software and working on modern technologies, we’d love to hear from you.</p>
HTML;

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'Careers',
            'slug' => $slug,
            'detail_content' => $detailContent,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 12,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => 'Careers at HilDes',
            'url' => 'https://www.hildes.io/careers',
            'description' => 'Explore career opportunities at HilDes in AI, SaaS, and software development.',
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'HilDes',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://www.hildes.io/logo.png',
                ],
            ],
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => 'HilDes',
                'sameAs' => 'https://www.hildes.io',
            ],
            'mainEntity' => [
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
        ];

        DB::table('seo_metas')->insert([
            'seoable_type' => 'App\Models\CmsPage',
            'seoable_id' => $pageId,
            'seo_enabled' => true,
            'is_indexable' => true,
            'include_in_sitemap' => true,
            'slug' => 'careers',
            'canonical_url' => 'https://www.hildes.io/careers',
            'meta_title' => 'Careers at HilDes | Join Our AI & Software Development Team',
            'meta_description' => 'Explore career opportunities at HilDes. Join our team to work on AI, SaaS, and cutting-edge software development projects.',
            'meta_keywords' => 'careers HilDes, software developer jobs, AI jobs, SaaS developer jobs, remote developer jobs, tech careers',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'careers HilDes',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'Careers at HilDes | Join Our Team',
            'og_description' => 'Work on AI, SaaS, and innovative software projects with HilDes. Explore open roles and grow your career.',
            'og_url' => 'https://www.hildes.io/careers',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Careers at HilDes',
            'twitter_description' => 'Join HilDes and work on cutting-edge AI and SaaS projects.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'careers')->first();
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
