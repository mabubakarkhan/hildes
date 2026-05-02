<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'terms-and-conditions';

        $existing = DB::table('cms_pages')->where('slug', $slug)->first();
        if ($existing) {
            return;
        }

        $detail = <<<'HTML'
<h2>Terms and Conditions</h2>
<p>Welcome to HilDes. These Terms and Conditions govern your use of our website and services. By accessing or using our platform, you agree to comply with and be bound by these terms.</p>

<h3>Use of Services</h3>
<p>By using our services, you agree to:</p>
<ul>
<li>Provide accurate and complete information</li>
<li>Use our services only for lawful purposes</li>
<li>Not engage in any activity that disrupts or interferes with our systems</li>
</ul>
<p>HilDes reserves the right to suspend or terminate access if these terms are violated.</p>

<h3>Intellectual Property</h3>
<p>All content, designs, code, and materials provided by HilDes are the intellectual property of HilDes unless otherwise stated.</p>
<ul>
<li>You may not copy, reproduce, or distribute our content without permission</li>
<li>Custom-developed solutions may be subject to separate contractual agreements regarding ownership</li>
</ul>

<h3>Service Agreements</h3>
<p>For project-based work, specific terms including scope, timelines, pricing, and deliverables will be defined in a separate agreement or contract. These agreements take precedence over general terms where applicable.</p>

<h3>Payments and Refunds</h3>
<ul>
<li>Payments must be made according to agreed milestones or invoices</li>
<li>Delayed payments may result in project delays or suspension</li>
<li>Refunds are subject to the terms defined in individual agreements</li>
</ul>

<h3>Limitation of Liability</h3>
<p>HilDes is not liable for:</p>
<ul>
<li>Any indirect, incidental, or consequential damages</li>
<li>Loss of data, revenue, or business opportunities</li>
<li>Issues arising from third-party services or integrations</li>
</ul>
<p>All services are provided "as is" without warranties unless explicitly stated.</p>

<h3>Third-Party Services</h3>
<p>Our solutions may integrate with third-party tools or services. HilDes is not responsible for the performance, policies, or reliability of these third-party services.</p>

<h3>Confidentiality</h3>
<p>We respect the confidentiality of client information and do not disclose sensitive data to unauthorized parties unless required by law.</p>

<h3>Termination</h3>
<p>We reserve the right to terminate or suspend access to our services at any time if terms are breached or misuse is detected.</p>

<h3>Changes to Terms</h3>
<p>HilDes may update these Terms and Conditions at any time. Continued use of the website or services constitutes acceptance of the updated terms.</p>

<h3>Governing Law</h3>
<p>These Terms shall be governed and interpreted in accordance with applicable laws. Any disputes will be handled under the relevant legal jurisdiction.</p>

<h3>Contact Information</h3>
<p>For any questions regarding these Terms and Conditions, please contact us:</p>
<p>Email: contact@hildes.io<br>Website: https://www.hildes.io</p>
HTML;

        $faqs = [
            ['title' => 'Do I need to agree to these terms to use HilDes services?', 'detail' => 'Yes, by using our website or services, you agree to these Terms and Conditions.'],
            ['title' => 'Can these terms change over time?', 'detail' => 'Yes, HilDes may update the terms, and continued use implies acceptance.'],
            ['title' => 'Are project-specific agreements separate?', 'detail' => 'Yes, project contracts define detailed scope and override general terms when applicable.'],
            ['title' => 'Does HilDes offer refunds?', 'detail' => 'Refunds depend on the specific agreement made for each project.'],
            ['title' => 'Is my data kept confidential?', 'detail' => 'Yes, HilDes maintains strict confidentiality of client information.'],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'Terms and Conditions',
            'slug' => $slug,
            'detail_content' => $detail,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebPage',
                    'name' => 'Terms and Conditions | HilDes',
                    'url' => 'https://www.hildes.io/terms-and-conditions',
                    'description' => 'Terms and Conditions outlining the rules and legal agreements for using HilDes services.',
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
            'canonical_url' => 'https://www.hildes.io/terms-and-conditions',
            'meta_title' => 'Terms and Conditions | HilDes',
            'meta_description' => 'Read the Terms and Conditions of HilDes to understand the rules, obligations, and legal agreements governing the use of our website and services.',
            'meta_keywords' => 'terms and conditions HilDes, website terms, software service agreement, user agreement, legal terms',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'terms and conditions HilDes',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'Terms and Conditions | HilDes',
            'og_description' => 'Understand the terms governing the use of HilDes services and website.',
            'og_url' => 'https://www.hildes.io/terms-and-conditions',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Terms and Conditions | HilDes',
            'twitter_description' => 'Review the legal terms and conditions for using HilDes services.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'terms-and-conditions')->first();
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
