<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'sla';

        $existing = DB::table('cms_pages')->where('slug', $slug)->first();
        if ($existing) {
            return;
        }

        $detail = <<<'HTML'
<h2>Service Level Agreement (SLA)</h2>
<p>This Service Level Agreement (SLA) outlines the service standards, support commitments, and performance benchmarks provided by HilDes for its AI solutions, SaaS platforms, and custom software services.</p>
<p>Our goal is to ensure reliability, transparency, and consistent service quality for all clients.</p>

<h3>Service Scope</h3>
<p>This SLA applies to:</p>
<ul>
<li>SaaS applications developed and maintained by HilDes</li>
<li>AI-based systems and automation solutions</li>
<li>Custom web and mobile applications under active support agreements</li>
</ul>
<p>Specific service terms may vary based on project contracts.</p>

<h3>Service Availability (Uptime Guarantee)</h3>
<p>HilDes is committed to maintaining high availability for all managed systems.</p>
<ul>
<li><strong>Target Uptime:</strong> 99.9% monthly uptime</li>
<li><strong>Scheduled Maintenance:</strong> Pre-notified and typically conducted during off-peak hours</li>
<li><strong>Unplanned Downtime:</strong> Actively monitored and resolved with priority</li>
</ul>

<h3>Support Availability</h3>
<p>We provide structured support to ensure smooth system operations:</p>
<ul>
<li><strong>Business Hours Support:</strong> Monday to Friday, standard business hours</li>
<li><strong>Extended Support (Optional):</strong> Available based on agreement</li>
<li><strong>Emergency Support:</strong> 24/7 support for critical issues (if included in contract)</li>
</ul>

<h3>Incident Response Time</h3>
<p>We classify incidents based on severity levels:</p>
<ul>
<li><strong>Critical (Severity 1):</strong> System outage or major functionality failure — Response Time: Within 1 hour</li>
<li><strong>High (Severity 2):</strong> Significant performance issues — Response Time: Within 4 hours</li>
<li><strong>Medium (Severity 3):</strong> Partial functionality issues — Response Time: Within 8 hours</li>
<li><strong>Low (Severity 4):</strong> Minor issues or general inquiries — Response Time: Within 24 hours</li>
</ul>

<h3>Resolution Time Objectives</h3>
<p>While resolution times may vary depending on complexity, we aim to:</p>
<ul>
<li>Resolve critical issues as quickly as possible</li>
<li>Provide continuous updates during issue handling</li>
<li>Deliver permanent fixes after root cause analysis</li>
</ul>

<h3>Maintenance and Updates</h3>
<p>HilDes performs regular maintenance to ensure optimal performance:</p>
<ul>
<li>Security updates and patches</li>
<li>Performance optimization</li>
<li>Feature enhancements (based on agreement)</li>
</ul>
<p>Clients will be notified in advance of any planned maintenance.</p>

<h3>Client Responsibilities</h3>
<p>To ensure effective service delivery, clients are expected to:</p>
<ul>
<li>Provide accurate and timely information</li>
<li>Report issues with sufficient detail</li>
<li>Maintain secure access credentials</li>
<li>Cooperate during troubleshooting processes</li>
</ul>

<h3>Service Exclusions</h3>
<p>This SLA does not cover:</p>
<ul>
<li>Issues caused by third-party services or integrations</li>
<li>Client-side misconfigurations</li>
<li>Force majeure events (e.g., natural disasters, network outages beyond control)</li>
</ul>

<h3>SLA Breach and Remedies</h3>
<p>In case of failure to meet SLA commitments:</p>
<ul>
<li>Issues will be escalated internally</li>
<li>Service credits or remedies may be provided based on agreement</li>
<li>Continuous improvements will be implemented</li>
</ul>

<h3>Changes to SLA</h3>
<p>HilDes may update this SLA periodically. Clients will be notified of significant changes affecting service commitments.</p>

<h3>Contact and Support</h3>
<p>For support requests or SLA-related queries:</p>
<p>Email: contact@hildes.io<br>Website: https://www.hildes.io</p>
HTML;

        $faqs = [
            ['title' => 'What uptime does HilDes guarantee?', 'detail' => 'HilDes provides a target uptime of 99.9% for supported systems.'],
            ['title' => 'Do you offer 24/7 support?', 'detail' => '24/7 support is available for critical issues if included in the service agreement.'],
            ['title' => 'How are incidents prioritized?', 'detail' => 'Incidents are categorized into four severity levels based on impact and urgency.'],
            ['title' => 'What happens if SLA targets are not met?', 'detail' => 'HilDes may provide service credits or remedies depending on the agreement.'],
            ['title' => 'Does SLA cover third-party issues?', 'detail' => 'No, issues caused by third-party services are not covered under the SLA.'],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'Service Level Agreement (SLA)',
            'slug' => $slug,
            'detail_content' => $detail,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 4,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebPage',
                    'name' => 'Service Level Agreement (SLA) | HilDes',
                    'url' => 'https://www.hildes.io/sla',
                    'description' => 'Service Level Agreement outlining uptime, support, and service commitments by HilDes.',
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'HilDes',
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => 'https://www.hildes.io/logo.png',
                        ],
                    ],
                    'about' => [
                        '@type' => 'Service',
                        'name' => 'Software Development and Support Services',
                        'provider' => [
                            '@type' => 'Organization',
                            'name' => 'HilDes',
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
            'canonical_url' => 'https://www.hildes.io/sla',
            'meta_title' => 'Service Level Agreement (SLA) | HilDes',
            'meta_description' => 'Review HilDes Service Level Agreement (SLA) covering uptime guarantees, support response times, issue resolution, and service commitments for AI, SaaS, and custom software solutions.',
            'meta_keywords' => 'SLA HilDes, service level agreement software company, uptime guarantee, support response time, SaaS SLA, AI service agreement',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'SLA HilDes',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'Service Level Agreement (SLA) | HilDes',
            'og_description' => 'Understand HilDes service commitments including uptime, support response times, and issue resolution standards.',
            'og_url' => 'https://www.hildes.io/sla',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Service Level Agreement (SLA) | HilDes',
            'twitter_description' => 'Explore HilDes SLA including uptime guarantees, support commitments, and response times.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'sla')->first();
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
