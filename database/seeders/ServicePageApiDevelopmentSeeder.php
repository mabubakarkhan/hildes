<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageApiDevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        $deliverables = <<<'TXT'
REST API development
GraphQL API development
Third-party system integrations
CRM & ERP integrations
Payment gateway integrations (Stripe, etc.)
Microservices architecture
Real-time data synchronization
Secure authentication systems (JWT, OAuth)
API documentation & versioning
Performance optimization & scaling
TXT;

        $process = <<<'TXT'
1. System Analysis
We analyze your existing tools, workflows, and integration needs.

2. API Architecture Design
We design scalable and secure API structures.

3. Development & Integration
We build APIs and connect all required systems.

4. Testing & Security Validation
We ensure reliability, performance, and security compliance.

5. Deployment & Monitoring
We deploy APIs and continuously monitor performance.
TXT;

        $globalFocus = <<<'TXT'
We build API ecosystems for clients across:
United States
United Kingdom
Canada
Europe
UAE
Our solutions follow international engineering standards for scalability, security, and reliability.
TXT;

        $faqRows = [
            [
                'title' => 'What is API development?',
                'detail' => 'API development involves building systems that allow different applications to communicate and exchange data securely.',
            ],
            [
                'title' => 'What types of APIs do you build?',
                'detail' => 'We build REST APIs, GraphQL APIs, and custom microservice-based APIs.',
            ],
            [
                'title' => 'Can you integrate third-party services?',
                'detail' => 'Yes, we integrate CRMs, payment gateways, SaaS tools, and enterprise systems.',
            ],
            [
                'title' => 'Are your APIs secure?',
                'detail' => 'Yes, we implement authentication, encryption, and security best practices in all APIs.',
            ],
            [
                'title' => 'Can you improve existing APIs?',
                'detail' => 'Yes, we optimize and scale existing APIs for performance and reliability.',
            ],
            [
                'title' => 'Do you provide API documentation?',
                'detail' => 'Yes, we deliver complete developer-friendly API documentation and version control.',
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
                    'name' => 'API Development & Integrations',
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
                    'serviceType' => 'API Development and System Integrations',
                    'url' => 'https://www.hildes.io/api-development',
                    'description' => 'HilDes provides API development and integration services including REST APIs, GraphQL APIs, microservices, and third-party integrations to automate workflows and connect systems.',
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
HilDes builds secure, scalable, and high-performance APIs that connect your applications, automate workflows, and unify your entire tech ecosystem.
We design and develop REST APIs, GraphQL APIs, and third-party integrations that enable seamless data flow between your systems, platforms, and external services — ensuring everything works together efficiently at scale.
TXT;

        $bodyContent = <<<'TXT'
Modern businesses rely on multiple software systems — CRMs, payment gateways, mobile apps, SaaS platforms, analytics tools, and third-party services. Without proper integration, these systems become isolated, creating inefficiencies, manual work, and data inconsistency.
At HilDes, we specialize in API development and system integration engineering that transforms disconnected tools into a unified, automated digital ecosystem.
We design and build high-performance APIs that are secure, scalable, and optimized for real-world usage. Whether you need internal system communication or external public APIs for third-party developers, we ensure your architecture is robust and future-ready.
Our APIs are designed using modern engineering principles such as stateless architecture, modular design, and versioning strategies, ensuring long-term maintainability and backward compatibility.
We also specialize in third-party integrations, connecting your systems with services like payment gateways, CRMs, ERP systems, marketing tools, and cloud platforms. This allows your business to automate repetitive tasks, synchronize data in real time, and eliminate manual workflows.
A key focus of our approach is workflow automation through APIs. By connecting your systems intelligently, we help you reduce operational overhead and improve efficiency across departments such as sales, marketing, operations, and customer support.
Security is deeply integrated into every API we build. We implement authentication, authorization, encryption, rate limiting, and monitoring systems to ensure your data and services remain protected at all times.
Performance and scalability are also core priorities. Our APIs are optimized to handle high traffic loads, large data volumes, and complex transactions without performance degradation.
With HilDes, you are not just getting APIs — you are getting a fully engineered integration layer that powers your entire business ecosystem and enables automation at scale.
TXT;

        $faqText = collect($faqRows)
            ->map(fn ($item, $index) => ($index + 1).'. '.$item['title'].PHP_EOL.$item['detail'])
            ->implode(PHP_EOL.PHP_EOL);

        $page = ServicePage::query()->updateOrCreate(
            ['slug' => 'api-development'],
            [
                'name' => 'API Development & Integrations',
                'is_published' => true,
                'hero_headline' => 'Seamless API Development & System Integrations for Scalable Digital Ecosystems',
                'hero_content' => trim($heroContent),
                'hero_image' => null,
                'body_heading' => 'Connect Systems. Automate Processes. Unlock Scalability.',
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
                'slug' => 'api-development',
                'canonical_url' => 'https://www.hildes.io/api-development',
                'meta_title' => 'API Development & Integration Services | Secure Scalable APIs | HilDes',
                'meta_description' => 'HilDes provides API development and integration services including REST APIs, GraphQL, third-party integrations, and microservices architecture. Connect systems, automate workflows, and scale your business with secure APIs.',
                'meta_keywords' => 'API development company, REST API development, GraphQL API services, system integration services, third-party API integration, microservices architecture, secure API development, backend API developers',
                'focus_keyword' => null,
                'robots_directive' => 'index,follow',
                'og_title' => 'API Development & Integration Services | HilDes',
                'og_description' => 'Build secure, scalable APIs and integrate systems to automate workflows and connect your entire digital ecosystem.',
                'og_image' => 'https://www.hildes.io/assets/og/api-development.jpg',
                'twitter_title' => 'API Development & Integration Services | HilDes',
                'twitter_description' => 'Secure, scalable API development and system integration services for modern businesses.',
                'twitter_image' => 'https://www.hildes.io/assets/og/api-development.jpg',
                'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ],
        );
    }
}
