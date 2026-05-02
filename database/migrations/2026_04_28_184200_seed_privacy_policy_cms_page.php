<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $slug = 'privacy-policy';

        $existing = DB::table('cms_pages')->where('slug', $slug)->first();
        if ($existing) {
            return;
        }

        $detail = <<<'HTML'
<h2>Privacy Policy</h2>
<p>At HilDes, we are committed to protecting your privacy and ensuring that your personal data is handled securely and transparently. This Privacy Policy explains how we collect, use, and safeguard your information when you interact with our website and services.</p>
<h3>Information We Collect</h3>
<p>We may collect the following types of information:</p>
<ol>
<li><strong>Personal Information</strong><br>When you contact us or use our services, we may collect details such as your name, email address, phone number, and company information.</li>
<li><strong>Technical Data</strong><br>We may collect IP address, browser type, device information, and usage behavior to improve user experience.</li>
<li><strong>Communication Data</strong><br>Any information you provide through contact forms, emails, or support requests.</li>
</ol>
<h3>How We Use Your Information</h3>
<p>We use your data to:</p>
<ul>
<li>Provide and improve our services</li>
<li>Respond to inquiries and communicate with you</li>
<li>Personalize user experience</li>
<li>Ensure security and prevent fraud</li>
<li>Comply with legal obligations</li>
</ul>
<p>We do not sell or rent your personal data to third parties.</p>
<h3>Cookies and Tracking Technologies</h3>
<p>HilDes uses cookies and similar tracking technologies to enhance website functionality and analyze user behavior. You can manage or disable cookies through your browser settings.</p>
<h3>Data Protection and Security</h3>
<p>We implement industry-standard security measures to protect your data from unauthorized access, misuse, or disclosure. However, no online system is completely secure, and we encourage users to take precautions when sharing information online.</p>
<h3>Third-Party Services</h3>
<p>We may use trusted third-party tools and services (such as analytics or payment processors) that may collect and process data in accordance with their own privacy policies.</p>
<h3>Your Rights</h3>
<p>Depending on your location, you may have the right to:</p>
<ul>
<li>Access your personal data</li>
<li>Request corrections or deletion</li>
<li>Withdraw consent for data processing</li>
<li>Request data portability</li>
</ul>
<p>To exercise these rights, you can contact us at contact@hildes.io.</p>
<h3>Data Retention</h3>
<p>We retain personal data only for as long as necessary to fulfill the purposes outlined in this policy or comply with legal requirements.</p>
<h3>Updates to This Policy</h3>
<p>We may update this Privacy Policy periodically. Any changes will be posted on this page with an updated effective date.</p>
<h3>Contact Us</h3>
<p>If you have any questions about this Privacy Policy or how your data is handled, please contact us:</p>
<p>Email: contact@hildes.io<br>Website: https://www.hildes.io</p>
HTML;

        $faqs = [
            ['title' => 'Does HilDes sell my personal data?', 'detail' => 'No, HilDes does not sell or rent your personal information to third parties.'],
            ['title' => 'What data does HilDes collect?', 'detail' => 'We collect personal, technical, and communication data to provide and improve our services.'],
            ['title' => 'Can I request deletion of my data?', 'detail' => 'Yes, you can request deletion of your personal data by contacting us.'],
            ['title' => 'How is my data protected?', 'detail' => 'We use industry-standard security measures to safeguard your information.'],
            ['title' => 'Do you use cookies?', 'detail' => 'Yes, we use cookies to improve user experience and analyze website performance.'],
        ];

        $pageId = DB::table('cms_pages')->insertGetId([
            'title' => 'Privacy Policy',
            'slug' => $slug,
            'detail_content' => $detail,
            'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES),
            'faq_schema_version' => 1,
            'faq_schema_updated_at' => $now,
            'is_published' => true,
            'display_order' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebPage',
                    'name' => 'Privacy Policy | HilDes',
                    'url' => 'https://www.hildes.io/privacy-policy',
                    'description' => 'Privacy Policy explaining how HilDes collects, uses, and protects user data.',
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'HilDes',
                        'logo' => ['@type' => 'ImageObject', 'url' => 'https://www.hildes.io/logo.png'],
                    ],
                ],
                [
                    '@type' => 'FAQPage',
                    'faq_schema_version' => 1,
                    'mainEntity' => array_map(static fn ($faq) => [
                        '@type' => 'Question',
                        'name' => $faq['title'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['detail']],
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
            'canonical_url' => 'https://www.hildes.io/privacy-policy',
            'meta_title' => 'Privacy Policy | HilDes',
            'meta_description' => 'Read the Privacy Policy of HilDes to understand how we collect, use, and protect your personal data when using our website and services.',
            'meta_keywords' => 'privacy policy HilDes, data protection, user privacy, GDPR compliance, data security policy',
            'meta_author' => 'HilDes',
            'meta_viewport' => 'width=device-width, initial-scale=1.0',
            'focus_keyword' => 'privacy policy HilDes',
            'robots_directive' => 'index, follow',
            'og_type' => 'website',
            'og_title' => 'Privacy Policy | HilDes',
            'og_description' => 'Learn how HilDes collects, uses, and protects your personal information.',
            'og_url' => 'https://www.hildes.io/privacy-policy',
            'og_site_name' => 'HilDes',
            'og_image' => 'https://www.hildes.io/og-image.jpg',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Privacy Policy | HilDes',
            'twitter_description' => 'Understand how your data is handled and protected at HilDes.',
            'twitter_image' => 'https://www.hildes.io/og-image.jpg',
            'schema_json' => json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        $page = DB::table('cms_pages')->where('slug', 'privacy-policy')->first();
        if (! $page) {
            return;
        }

        DB::table('seo_metas')->where('seoable_type', 'App\Models\CmsPage')->where('seoable_id', $page->id)->delete();
        DB::table('cms_pages')->where('id', $page->id)->delete();
    }
};
