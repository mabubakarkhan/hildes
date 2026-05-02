<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageCustomWebDevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        $deliverables = <<<'TXT'
Custom web application development
SaaS platforms and dashboards
Enterprise-grade backend systems
Admin panels and internal tools
API-first architectures
Secure authentication systems
Cloud-ready deployment setups
TXT;

        $process = <<<'TXT'
1. Discovery & Requirement Analysis
We understand your business model, users, and technical needs.

2. System Architecture Design
We design scalable and maintainable architecture before coding begins.

3. UI/UX & Prototyping
We design intuitive interfaces and user flows.

4. Agile Development
We build in iterative cycles with continuous feedback.

5. Testing & Deployment
We ensure performance, security, and reliability before launch.
TXT;

        $globalFocus = <<<'TXT'
We develop web applications for clients across:
United States
United Kingdom
Canada
Europe
UAE
Our solutions follow international standards in performance, usability, and security, ensuring your product is ready for global users from day one.
TXT;

        $faqRows = [
            [
                'title' => 'What technologies do you use for web development?',
                'detail' => 'We use modern stacks like React, Node.js, PHP, and cloud platforms like AWS, Azure, and Google Cloud depending on project requirements.',
            ],
            [
                'title' => 'How much does a custom web application cost?',
                'detail' => 'Cost depends on complexity, features, and scale. Simple applications are more affordable, while enterprise systems require larger investment. We provide tailored quotes after analysis.',
            ],
            [
                'title' => 'How long does it take to build a web application?',
                'detail' => 'Most projects take between 3–12 weeks depending on scope and complexity.',
            ],
            [
                'title' => 'Can you rebuild or improve my existing system?',
                'detail' => 'Yes. We specialize in modernizing legacy systems and improving performance, scalability, and design.',
            ],
            [
                'title' => 'Will my application be scalable?',
                'detail' => 'Yes. We design all systems with scalability in mind so they can grow with your business.',
            ],
            [
                'title' => 'Do you also provide ongoing support?',
                'detail' => 'Yes. We offer maintenance, optimization, and scaling support after launch.',
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
                    'name' => 'Custom Web Development',
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
                    'serviceType' => 'Custom Web Development',
                    'areaServed' => [
                        ['@type' => 'Country', 'name' => 'United States'],
                        ['@type' => 'Country', 'name' => 'United Kingdom'],
                        ['@type' => 'Country', 'name' => 'Canada'],
                        ['@type' => 'Country', 'name' => 'Germany'],
                        ['@type' => 'Country', 'name' => 'United Arab Emirates'],
                    ],
                    'description' => 'HilDes provides custom web development services for startups and enterprises, building scalable, secure, and high-performance web applications using modern technologies like React, Node.js, PHP, and cloud platforms such as AWS, Azure, and Google Cloud.',
                    'url' => 'https://www.hildes.io/custom-web-development',
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => 'Custom',
                        'priceCurrency' => 'USD',
                        'availability' => 'https://schema.org/InStock',
                    ],
                    'category' => 'Web Development Services',
                    'hasOfferCatalog' => [
                        '@type' => 'OfferCatalog',
                        'name' => 'Web Development Solutions',
                        'itemListElement' => [
                            ['@type' => 'OfferCatalog', 'name' => 'Custom Web Applications'],
                            ['@type' => 'OfferCatalog', 'name' => 'SaaS Development'],
                            ['@type' => 'OfferCatalog', 'name' => 'Enterprise Web Systems'],
                            ['@type' => 'OfferCatalog', 'name' => 'API Development'],
                        ],
                    ],
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => $faqMainEntity,
                ],
            ],
        ];

        $heroContent = <<<'TXT'
At HilDes, we design and build custom web applications that power modern businesses. From startups to enterprise systems, we develop secure, fast, and scalable platforms tailored to your exact requirements.
We don’t use generic templates. Every system is engineered from the ground up to ensure performance, flexibility, and long-term scalability.
Whether you're launching a new product or rebuilding an existing system, we help you create web applications that are built to grow with your business globally.
TXT;

        $bodyContent = <<<'TXT'
Custom web development is not just about writing code — it’s about building the foundation of your digital business. A well-architected web application becomes your core operational system, handling users, transactions, workflows, and growth at scale.
At HilDes, we specialize in developing high-performance, custom-built web applications designed for real-world usage and long-term business expansion. Our focus is not just on delivering functional software, but on creating systems that are fast, secure, maintainable, and capable of handling increasing complexity over time.
We work closely with businesses to understand their workflows, user journeys, and operational challenges. This allows us to design solutions that are not only technically strong but also aligned with business goals such as increasing efficiency, improving user experience, and enabling new revenue streams.
Our development approach is rooted in modern engineering practices, using technologies like React, Node.js, and PHP, combined with scalable backend architectures and cloud infrastructure. This ensures your application performs reliably even under heavy traffic and large datasets.
We place strong emphasis on system architecture and code quality. Every application is built with modular design principles, clean APIs, and optimized database structures to ensure future scalability without requiring complete rebuilds.
Security is also a core part of our development process. We implement industry-standard practices such as secure authentication, data encryption, role-based access control, and performance monitoring to ensure your application is safe and stable.
Beyond development, we think like product engineers. We help you make strategic decisions about features, scalability, and technical direction so your application becomes a long-term asset rather than just a short-term solution.
With HilDes, you are not just hiring developers — you are partnering with a team that builds production-grade digital systems designed for global performance and scalability.
TXT;

        $faqText = collect($faqRows)
            ->map(fn ($item, $index) => ($index + 1).'. '.$item['title'].PHP_EOL.$item['detail'])
            ->implode(PHP_EOL.PHP_EOL);

        $page = ServicePage::query()->updateOrCreate(
            ['slug' => 'custom-web-development'],
            [
                'name' => 'Custom Web Development That Scales',
                'is_published' => true,
                'hero_headline' => 'Custom Web Development for Scalable, High-Performance Digital Products',
                'hero_content' => trim($heroContent),
                'hero_image' => null,
                'body_heading' => 'Engineering Web Applications That Go Beyond Development',
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
                'slug' => 'custom-web-development',
                'canonical_url' => 'https://www.hildes.io/custom-web-development',
                'meta_title' => 'Custom Web Development Services | Scalable Web Apps | HilDes',
                'meta_description' => 'Hire HilDes for custom web development services built for scalability, performance, and security. We build high-quality web applications, SaaS platforms, dashboards, and enterprise systems for clients in the US, UK, Europe, Canada, and UAE. Fast delivery, modern tech stack, and production-ready solutions.',
                'meta_keywords' => 'custom web development, web development company, hire web developers, SaaS development services, scalable web applications, enterprise web development, React Node.js development, offshore web development company, API development services, cloud web applications',
                'focus_keyword' => null,
                'robots_directive' => 'index,follow',
                'og_title' => 'Custom Web Development Services | HilDes',
                'og_description' => 'Scalable, secure, and high-performance web applications built for global businesses. Hire HilDes for modern custom web development solutions.',
                'og_image' => 'https://www.hildes.io/assets/og/custom-web-development.jpg',
                'twitter_title' => 'Custom Web Development Services | HilDes',
                'twitter_description' => 'Scalable, secure, and high-performance web applications built for global businesses.',
                'twitter_image' => 'https://www.hildes.io/assets/og/custom-web-development.jpg',
                'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ],
        );
    }
}
