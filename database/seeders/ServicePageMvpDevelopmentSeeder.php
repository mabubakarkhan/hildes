<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageMvpDevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        $deliverables = <<<'TXT'
End-to-end MVP development
SaaS MVPs and startup platforms
Web app MVPs and dashboards
UI/UX design for early-stage products
Scalable backend architecture
API integrations
Cloud deployment (AWS, Azure, GCP)
Post-launch iteration support
TXT;

        $process = <<<'TXT'
1. Idea Discovery & Validation
We analyze your idea, users, and business model.

2. Feature Prioritization
We define the core features needed for MVP success.

3. UI/UX Design
We design intuitive, user-friendly product interfaces.

4. Agile MVP Development
We build a lean, functional version of your product.

5. Launch & Iteration
We launch quickly and improve based on real user feedback.
TXT;

        $globalFocus = <<<'TXT'
We build MVPs for founders targeting:
United States
United Kingdom
Canada
Europe
UAE
Our MVPs are built to meet global startup standards in usability, performance, and scalability.
TXT;

        $faqRows = [
            [
                'title' => 'What is an MVP?',
                'detail' => 'An MVP (Minimum Viable Product) is the simplest working version of a product that allows you to test your idea in the real market.',
            ],
            [
                'title' => 'How long does it take to build an MVP?',
                'detail' => 'Most MVPs are built in 2–6 weeks depending on complexity.',
            ],
            [
                'title' => 'Why should I start with an MVP?',
                'detail' => 'It reduces risk, saves cost, and helps validate your idea before full investment.',
            ],
            [
                'title' => 'Can my MVP be scaled later?',
                'detail' => 'Yes, we build MVPs with scalable architecture so they can evolve into full products.',
            ],
            [
                'title' => 'Do you help with idea validation?',
                'detail' => 'Yes, we help refine your idea and prioritize features for market success.',
            ],
            [
                'title' => 'What types of MVPs do you build?',
                'detail' => 'We build SaaS MVPs, marketplaces, dashboards, AI products, and web applications.',
            ],
        ];

        $faqMainEntity = collect($faqRows)->map(fn ($item) => [
            '@type' => 'Question',
            'name' => $item['title'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $item['detail'],
            ],
        ])->values()->all();

        $schemaGraph = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    'name' => 'MVP Development',
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
                    'serviceType' => 'MVP Development',
                    'url' => 'https://www.hildes.io/mvp-development',
                    'description' => 'HilDes provides MVP development services for startups, building scalable and lean products that help validate ideas and achieve product-market fit quickly.',
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
HilDes helps startups and founders transform ideas into working MVPs in weeks — not months. We design and build lean, scalable products that allow you to test your idea in the real market, attract users, and secure investor interest.
From concept to launch, we build MVPs that are fast, functional, and ready to scale into full products.
TXT;

        $bodyContent = <<<'TXT'
Most startups fail not because of poor execution, but because they build the wrong product. Over-investing in unnecessary features, unclear product direction, and long development cycles often lead to wasted time and budget.
At HilDes, we specialize in MVP (Minimum Viable Product) development designed to eliminate uncertainty and accelerate validation. Our approach focuses on building only what is essential — the core features that solve real user problems and demonstrate product-market fit.
We work closely with founders to define the core value proposition of the product, identify key user journeys, and prioritize features based on real-world impact. This ensures that your MVP is not just a prototype, but a functional, market-ready product that can generate real user feedback.
Our MVP development process is built on lean product engineering principles. Instead of overbuilding, we focus on speed, clarity, and iteration. This allows you to launch quickly, test assumptions, and refine your product based on actual user behavior rather than speculation.
We use modern technologies such as React, Node.js, and cloud platforms like AWS, Azure, and Google Cloud to ensure your MVP is not a temporary prototype but a scalable foundation for future growth. This means your product can evolve into a full SaaS platform or enterprise system without requiring a complete rebuild.
Beyond development, we act as technical product partners. We help you make strategic decisions about feature prioritization, architecture design, and scalability planning so your MVP is aligned with long-term business goals.
Our goal is simple: help you reduce risk, accelerate validation, and reach product-market fit faster.
With HilDes, you are not just building an MVP — you are building the foundation of a scalable digital business.
TXT;

        $faqText = collect($faqRows)
            ->map(fn ($item, $index) => ($index + 1).'. '.$item['title'].PHP_EOL.$item['detail'])
            ->implode(PHP_EOL.PHP_EOL);

        $page = ServicePage::query()->updateOrCreate(
            ['slug' => 'mvp-development'],
            [
                'name' => 'MVP Development',
                'is_published' => true,
                'hero_headline' => 'Launch Your MVP Fast, Validate Faster, Scale Confidently',
                'hero_content' => trim($heroContent),
                'hero_image' => null,
                'body_heading' => 'Build the Right Product Before You Build the Full Product',
                'body_content' => trim($bodyContent),
                'body_image' => null,
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
                'slug' => 'mvp-development',
                'canonical_url' => 'https://www.hildes.io/mvp-development',
                'meta_title' => 'MVP Development Company | Build & Launch Startup MVPs Fast | HilDes',
                'meta_description' => 'HilDes builds scalable MVPs for startups and founders. Launch your product fast, validate ideas, and reduce risk with expert MVP development services using modern technologies like React, Node.js, and cloud infrastructure.',
                'meta_keywords' => 'MVP development company, startup MVP development, build MVP fast, SaaS MVP development, hire MVP developers, startup product development, lean startup development, web app MVP services',
                'focus_keyword' => null,
                'robots_directive' => 'index,follow',
                'og_title' => 'MVP Development Company | HilDes',
                'og_description' => 'Build and launch scalable MVPs fast to validate your startup idea and reach product-market fit.',
                'og_image' => 'https://www.hildes.io/assets/og/mvp-development.jpg',
                'twitter_title' => 'MVP Development Company | HilDes',
                'twitter_description' => 'Launch scalable MVPs fast, validate ideas, and build the foundation for your startup success.',
                'twitter_image' => 'https://www.hildes.io/assets/og/mvp-development.jpg',
                'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ],
        );
    }
}
