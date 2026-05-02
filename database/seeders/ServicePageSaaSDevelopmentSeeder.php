<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageSaaSDevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        $deliverables = <<<'TXT'
End-to-end SaaS product development
Multi-tenant architecture design
Subscription & billing systems (Stripe, etc.)
User roles & access management
SaaS dashboards & analytics
Cloud-native backend systems
API-first architecture
Scalable deployment on AWS, Azure, GCP
TXT;

        $process = <<<'TXT'
1. Product Discovery
We define your SaaS idea, audience, and core features.

2. Architecture Design
We design scalable, secure multi-tenant systems.

3. MVP Development
We build a lean version to validate your idea quickly.

4. Full Product Development
We expand features based on real user feedback.

5. Cloud Deployment & Scaling
We deploy and optimize for global performance.
TXT;

        $globalFocus = <<<'TXT'
We build SaaS platforms for clients targeting:
United States
United Kingdom
Canada
Europe
UAE
All systems are built to meet international SaaS standards in performance, scalability, and UX.
TXT;

        $faqText = <<<'TXT'
1. What is SaaS development?
SaaS development involves building cloud-based software products that users access online via subscription models.

2. How long does it take to build a SaaS product?
An MVP can take 4–8 weeks, while a full SaaS platform may take 3–6 months depending on complexity.

3. Do you build multi-tenant SaaS systems?
Yes, we specialize in secure multi-tenant architectures designed for scalability and efficiency.

4. Can you integrate payments and subscriptions?
Yes, we integrate Stripe and other billing systems for recurring revenue models.

5. Will my SaaS be scalable?
Yes, all systems are designed with cloud-native architecture for global scaling.

6. Do you help with MVP planning?
Yes, we help define MVP scope and build lean versions for faster validation.
TXT;

        $faqMainEntity = [
            [
                '@type' => 'Question',
                'name' => 'What is SaaS development?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'SaaS development involves building cloud-based software products that users access online through subscription models.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'How long does it take to build a SaaS product?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'An MVP typically takes 4–8 weeks, while full SaaS platforms can take 3–6 months depending on complexity.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Do you build multi-tenant SaaS systems?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes, we specialize in building scalable multi-tenant SaaS architectures with secure data isolation.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Can you integrate payments and subscriptions?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes, we integrate Stripe and other billing systems for recurring revenue models.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Will my SaaS be scalable?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes, all systems are designed with cloud-native architecture for global scaling.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Do you help with MVP planning?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes, we help define MVP scope and build lean versions for faster validation.',
                ],
            ],
        ];

        $faqRows = collect($faqMainEntity)->map(fn ($item) => [
            'title' => $item['name'],
            'detail' => data_get($item, 'acceptedAnswer.text', ''),
        ])->values()->all();

        $schemaGraph = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    'name' => 'SaaS Development',
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => 'HilDes',
                        'url' => 'https://www.hildes.io',
                        'address' => [
                            '@type' => 'PostalAddress',
                            'addressLocality' => 'Lahore',
                            'addressCountry' => 'Pakistan',
                        ],
                    ],
                    'serviceType' => 'SaaS Development',
                    'url' => 'https://www.hildes.io/saas-development',
                    'description' => 'HilDes provides SaaS development services, building scalable, secure, multi-tenant cloud platforms with modern technologies like React, Node.js, and AWS.',
                    'areaServed' => [
                        ['@type' => 'Country', 'name' => 'United States'],
                        ['@type' => 'Country', 'name' => 'United Kingdom'],
                        ['@type' => 'Country', 'name' => 'Canada'],
                        ['@type' => 'Country', 'name' => 'Germany'],
                        ['@type' => 'Country', 'name' => 'United Arab Emirates'],
                    ],
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => 'Custom',
                        'priceCurrency' => 'USD',
                        'availability' => 'https://schema.org/InStock',
                    ],
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => $faqMainEntity,
                ],
            ],
        ];

        $heroContent = <<<'TXT'
HilDes designs and develops high-performance SaaS platforms for startups and enterprises worldwide. We help you transform ideas into fully functional, cloud-native SaaS products built for scale, performance, and long-term growth.
From MVP to enterprise SaaS systems, we build products that are secure, multi-tenant, and ready for global users.
TXT;

        $bodyContent = <<<'TXT'
Building a successful SaaS product requires far more than just development. It demands a deep understanding of architecture, scalability, user behavior, and long-term product evolution. At HilDes, we specialize in end-to-end SaaS development, helping founders and businesses turn ideas into production-ready, revenue-generating platforms.
We design SaaS systems using modern cloud-native architecture, ensuring your application can scale seamlessly as your user base grows. Whether you're targeting your first 100 users or planning for 100,000+ active customers, our systems are engineered to handle growth without performance degradation.
A core part of our approach is multi-tenant architecture design, allowing you to serve multiple customers securely and efficiently from a single platform. This reduces infrastructure costs while maintaining strict data isolation, security, and performance standards for each client.
We also focus heavily on subscription-based business models, integrating recurring billing systems, user role management, analytics dashboards, and automated workflows. This ensures your SaaS product is not just functional but optimized for monetization and retention.
Our development stack includes modern technologies such as React, Node.js, and cloud platforms like AWS, Azure, and Google Cloud, enabling high-performance applications with global scalability. We design systems that are API-first, modular, and maintainable — so your product can evolve without technical limitations.
Beyond engineering, we act as product partners. We help you define MVP scope, prioritize features, and reduce time-to-market so you can validate your idea quickly and iterate based on real user feedback.
Security, performance, and reliability are built into every layer of our SaaS development process. From authentication systems to data encryption and infrastructure monitoring, we ensure your platform meets international standards and builds trust with users.
With HilDes, you are not just building software — you are building a scalable SaaS business designed for global markets and long-term success.
TXT;

        $page = ServicePage::query()->updateOrCreate(
            ['slug' => 'saas-development'],
            [
                'name' => 'SaaS Development',
                'is_published' => true,
                'hero_headline' => 'Build Scalable SaaS Products That Generate Real Revenue',
                'hero_content' => trim($heroContent),
                'body_heading' => 'From Idea to Scalable SaaS Platform — Built for Growth',
                'body_content' => trim($bodyContent),
                'deliverables_text' => trim($deliverables),
                'process_text' => trim($process),
                'global_focus_text' => trim($globalFocus),
                'faq_text' => trim($faqText),
                'faqs_json' => $faqRows,
            ],
        );

        $page->seoMeta()->updateOrCreate(
            [],
            [
                'seo_enabled' => true,
                'is_indexable' => true,
                'include_in_sitemap' => true,
                'slug' => 'saas-development',
                'canonical_url' => 'https://www.hildes.io/saas-development',
                'meta_title' => 'SaaS Development Company | Scalable SaaS Platforms | HilDes',
                'meta_description' => 'HilDes provides SaaS development services for startups and enterprises, building scalable, secure, multi-tenant cloud platforms using modern technologies like React, Node.js, and AWS. Launch your SaaS product faster with expert development support.',
                'meta_keywords' => 'SaaS development company, SaaS product development, multi tenant SaaS, SaaS platform development, hire SaaS developers, cloud SaaS applications, startup SaaS development, scalable SaaS architecture',
                'focus_keyword' => null,
                'robots_directive' => 'index,follow',
                'og_title' => 'SaaS Development Company | HilDes',
                'og_description' => 'Build scalable SaaS platforms with multi-tenant architecture, subscription systems, and cloud-native infrastructure.',
                'og_image' => 'https://www.hildes.io/assets/og/saas-development.jpg',
                'twitter_title' => 'SaaS Development Company | HilDes',
                'twitter_description' => 'Build scalable SaaS platforms with subscription systems, cloud infrastructure, and multi-tenant architecture.',
                'twitter_image' => 'https://www.hildes.io/assets/og/saas-development.jpg',
                'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ],
        );
    }
}
