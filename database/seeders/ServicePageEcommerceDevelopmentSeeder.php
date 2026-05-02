<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageEcommerceDevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        $deliverables = <<<'TXT'
Custom e-commerce website development
Shopify store development & customization
WooCommerce development
Headless commerce solutions
Payment gateway integration (Stripe, PayPal, etc.)
Inventory & order management systems
Conversion-optimized UX/UI design
Mobile-first responsive stores
Third-party integrations (CRM, ERP, marketing tools)
Performance optimization & scaling
TXT;

        $process = <<<'TXT'
1. Business & Product Analysis
We understand your products, audience, and revenue goals.

2. UX & Conversion Strategy
We design user journeys optimized for sales conversion.

3. Store Development
We build your e-commerce platform using the best-fit technology stack.

4. Integration & Testing
We integrate payments, inventory, and third-party systems.

5. Launch & Optimization
We deploy your store and continuously optimize for performance and sales.
TXT;

        $globalFocus = <<<'TXT'
We build e-commerce platforms for businesses targeting:
United States
United Kingdom
Canada
Europe
UAE
Our solutions are built to meet international standards in speed, security, UX, and scalability.
TXT;

        $faqRows = [
            [
                'title' => 'Which e-commerce platform is best for my business?',
                'detail' => 'It depends on your needs. Shopify is ideal for fast launch, WooCommerce for flexibility, and custom solutions for scalability.',
            ],
            [
                'title' => 'Can you build a fully custom e-commerce platform?',
                'detail' => 'Yes, we build custom and headless commerce systems tailored to your business model.',
            ],
            [
                'title' => 'Do you integrate payment gateways?',
                'detail' => 'Yes, we integrate Stripe, PayPal, and other global payment systems securely.',
            ],
            [
                'title' => 'Will my store be mobile optimized?',
                'detail' => 'Absolutely. All stores are built mobile-first for maximum conversions.',
            ],
            [
                'title' => 'Can you improve my existing store?',
                'detail' => 'Yes, we optimize speed, UX, and conversion rates of existing e-commerce platforms.',
            ],
            [
                'title' => 'Do you help increase sales?',
                'detail' => 'Yes, we focus on conversion rate optimization, UX flow, and performance improvements.',
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
                    'name' => 'E-commerce Development',
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
                    'serviceType' => 'E-commerce Development',
                    'url' => 'https://www.hildes.io/ecommerce-development',
                    'description' => 'HilDes provides e-commerce development services including Shopify, WooCommerce, and custom online stores designed for high conversion, scalability, and global sales.',
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
HilDes builds modern, fast, and conversion-optimized e-commerce platforms designed to maximize revenue and deliver seamless shopping experiences.
We develop custom online stores, Shopify solutions, WooCommerce systems, and headless commerce platforms engineered for speed, scalability, and high conversion rates across global markets.
TXT;

        $bodyContent = <<<'TXT'
In e-commerce, success is not defined by design alone — it is defined by conversion rate, performance, and customer experience. Many online stores fail because they are slow, poorly structured, or not optimized for buyer behavior.
At HilDes, we specialize in building high-performance e-commerce systems engineered for revenue growth. Every store we develop is designed with a deep focus on user experience, conversion optimization, and scalable architecture.
We don’t just create online stores — we build digital sales systems that guide users from product discovery to checkout with minimal friction. This includes optimized product pages, intuitive navigation structures, and streamlined checkout flows designed to reduce cart abandonment and increase completed purchases.
Our e-commerce solutions are built using modern technologies and platforms such as Shopify, WooCommerce, and custom headless commerce architectures, depending on the complexity and scalability requirements of your business.
For growing brands and enterprises, we build custom e-commerce systems with API-first architecture, enabling seamless integration with inventory systems, CRM platforms, ERP tools, and marketing automation systems.
Performance is a critical factor in e-commerce success. We ensure your store is fast-loading, mobile-optimized, and capable of handling high traffic volumes without performance degradation — especially during peak sales events.
We also integrate essential business systems such as secure payment gateways, shipping automation, order management, and analytics dashboards, giving you complete control over your operations and revenue tracking.
Beyond development, we focus on conversion rate optimization (CRO) strategies, ensuring your platform is structured to maximize sales and average order value through smart UX design and behavioral flow optimization.
With HilDes, you are not just launching an online store — you are building a scalable, revenue-driven e-commerce ecosystem designed for global competition.
TXT;

        $faqText = collect($faqRows)
            ->map(fn ($item, $index) => ($index + 1).'. '.$item['title'].PHP_EOL.$item['detail'])
            ->implode(PHP_EOL.PHP_EOL);

        $page = ServicePage::query()->updateOrCreate(
            ['slug' => 'ecommerce-development'],
            [
                'name' => 'E-commerce Development',
                'is_published' => true,
                'hero_headline' => 'High-Performance E-commerce Development That Drives Sales & Scales Globally',
                'hero_content' => trim($heroContent),
                'hero_image' => null,
                'body_heading' => 'Build an E-commerce Platform That Doesn’t Just Look Good — It Sells',
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
                'slug' => 'ecommerce-development',
                'canonical_url' => 'https://www.hildes.io/ecommerce-development',
                'meta_title' => 'E-commerce Development Company | High-Converting Online Stores | HilDes',
                'meta_description' => 'HilDes builds high-performance e-commerce websites designed to increase sales and conversions. We develop Shopify, WooCommerce, and custom online stores optimized for speed, UX, and global scalability.',
                'meta_keywords' => 'ecommerce development company, custom ecommerce website, Shopify development services, WooCommerce developer, online store development, headless commerce, conversion optimized ecommerce, hire ecommerce developers',
                'focus_keyword' => null,
                'robots_directive' => 'index,follow',
                'og_title' => 'E-commerce Development Services | HilDes',
                'og_description' => 'Build fast, scalable, and conversion-optimized e-commerce platforms designed to maximize revenue and global sales.',
                'og_image' => 'https://www.hildes.io/assets/og/ecommerce-development.jpg',
                'twitter_title' => 'E-commerce Development Services | HilDes',
                'twitter_description' => 'High-performance online stores built for conversions, scalability, and global e-commerce success.',
                'twitter_image' => 'https://www.hildes.io/assets/og/ecommerce-development.jpg',
                'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ],
        );
    }
}
