<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageUiUxDesignSeeder extends Seeder
{
    public function run(): void
    {
        $deliverables = <<<'TXT'
UI/UX design for web & mobile apps
SaaS dashboard design
User flow & journey mapping
Wireframing & prototyping
Design systems & component libraries
Conversion-focused UX optimization
Mobile-first responsive design
SaaS product interface design
Usability improvements for existing products
Developer-ready design handoff (Figma)
TXT;

        $process = <<<'TXT'
1. Product & User Research
We understand users, business goals, and product requirements.

2. UX Strategy & Flow Design
We design user journeys and interaction flows.

3. Wireframing
We create low-fidelity structures for validation.

4. UI Design
We design high-fidelity modern interfaces and systems.

5. Testing & Iteration
We refine designs based on usability and feedback.
TXT;

        $globalFocus = <<<'TXT'
We design digital experiences for clients across:
United States
United Kingdom
Canada
Europe
UAE
Our design systems follow international UX standards and modern SaaS design practices.
TXT;

        $faqRows = [
            [
                'title' => 'What is UI/UX design?',
                'detail' => 'UI/UX design is the process of creating user interfaces and experiences that are easy to use, visually appealing, and conversion-focused.',
            ],
            [
                'title' => 'Why is UI/UX important?',
                'detail' => 'Good UI/UX improves user engagement, reduces bounce rates, and increases conversions and retention.',
            ],
            [
                'title' => 'Do you design SaaS dashboards?',
                'detail' => 'Yes, we specialize in SaaS dashboards and complex data-driven interfaces.',
            ],
            [
                'title' => 'Do you also implement the design?',
                'detail' => 'Yes, we collaborate with developers to ensure smooth implementation.',
            ],
            [
                'title' => 'What tools do you use?',
                'detail' => 'We primarily use Figma for design systems, wireframes, and prototyping.',
            ],
            [
                'title' => 'Can you improve existing designs?',
                'detail' => 'Yes, we redesign and optimize existing products for better usability and conversions.',
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
                    'name' => 'UI/UX Design',
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
                    'serviceType' => 'UI UX Design',
                    'url' => 'https://www.hildes.io/ui-ux-design',
                    'description' => 'HilDes provides UI/UX design services for SaaS, web, and mobile applications focused on usability, conversion optimization, and modern user experience design.',
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
HilDes designs intuitive, modern, and conversion-driven digital experiences for web and SaaS products. We combine user psychology, product thinking, and clean design systems to create interfaces that are not only visually appealing but also highly effective.
From SaaS dashboards to mobile apps and enterprise systems, we design experiences that users understand instantly and enjoy using.
TXT;

        $bodyContent = <<<'TXT'
Great products are not defined by features alone — they are defined by how easily users can understand and interact with them. Poor design leads to confusion, drop-offs, and lost revenue, while great design improves retention, engagement, and conversions.
At HilDes, we specialize in UI/UX design for modern digital products, focusing on both visual clarity and functional usability. Our approach is rooted in user behavior analysis, product logic, and conversion optimization principles rather than just aesthetics.
We design interfaces that guide users naturally through key actions — whether that is signing up, purchasing, managing data, or interacting with complex systems. Every screen is designed with a clear purpose and optimized user flow.
Our UX process begins with understanding your users, business model, and product goals. We map out user journeys, identify friction points, and design structures that eliminate unnecessary complexity. This ensures your product feels intuitive from the very first interaction.
On the UI side, we create modern, clean, and scalable design systems that align with your brand identity while maintaining consistency across all screens and devices. This includes typography systems, color systems, component libraries, and reusable UI elements.
We also focus heavily on conversion rate optimization (CRO) — designing interfaces that improve sign-ups, purchases, and engagement metrics. Every design decision is backed by usability principles and real-world product behavior insights.
For SaaS platforms and dashboards, we design data-heavy interfaces that remain simple, structured, and easy to navigate, ensuring users can interact with complex systems without friction.
We collaborate closely with development teams to ensure designs are implementation-ready, reducing gaps between design and final product execution.
With HilDes, UI/UX design is not just about making things look good — it is about creating high-performing digital experiences that drive business results.
TXT;

        $faqText = collect($faqRows)
            ->map(fn ($item, $index) => ($index + 1).'. '.$item['title'].PHP_EOL.$item['detail'])
            ->implode(PHP_EOL.PHP_EOL);

        $page = ServicePage::query()->updateOrCreate(
            ['slug' => 'ui-ux-design'],
            [
                'name' => 'UI/UX Design',
                'is_published' => true,
                'hero_headline' => 'User-Centered UI/UX Design That Improves Engagement & Increases Conversions',
                'hero_content' => trim($heroContent),
                'hero_image' => null,
                'body_heading' => 'Design Experiences That Users Understand, Trust, and Convert With',
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
                'slug' => 'ui-ux-design',
                'canonical_url' => 'https://www.hildes.io/ui-ux-design',
                'meta_title' => 'UI UX Design Services Company | SaaS & Web Design Experts | HilDes',
                'meta_description' => 'HilDes provides UI/UX design services for SaaS, web, and mobile applications. We design user-centered interfaces that improve engagement, usability, and conversion rates for global businesses.',
                'meta_keywords' => 'UI UX design company, SaaS UI UX design, web app design services, product design agency, Figma design services, dashboard UI design, UX optimization services, hire UI UX designers',
                'focus_keyword' => null,
                'robots_directive' => 'index,follow',
                'og_title' => 'UI/UX Design Services | HilDes',
                'og_description' => 'User-centered UI/UX design for SaaS, web, and mobile apps that improves engagement and conversions.',
                'og_image' => 'https://www.hildes.io/assets/og/ui-ux-design.jpg',
                'twitter_title' => 'UI/UX Design Services | HilDes',
                'twitter_description' => 'Modern UI/UX design for SaaS and web applications focused on usability, engagement, and conversions.',
                'twitter_image' => 'https://www.hildes.io/assets/og/ui-ux-design.jpg',
                'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ],
        );
    }
}
