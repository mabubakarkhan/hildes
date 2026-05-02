<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageAiAppRescueSeeder extends Seeder
{
    public function run(): void
    {
        $deliverables = <<<'TXT'
Fix broken AI-generated applications
Debug frontend and backend issues
Repair APIs and database connections
Clean and restructure messy codebases
Complete unfinished features
Set up authentication systems
GitHub repository setup & optimization
Deploy apps to production (Vercel, AWS, DigitalOcean, etc.)
Configure domains, hosting, and environments
Build CI/CD pipelines for automation
Improve performance and scalability
TXT;

        $process = <<<'TXT'
1. Code & Project Review
We analyze your existing app, repository, or AI-generated output.

2. Issue Identification
We identify critical bugs, architecture issues, and missing components.

3. Stabilization & Fixing
We fix core functionality and make the app stable.

4. Refactoring & Optimization
We restructure code for scalability and maintainability.

5. Deployment & Launch
We deploy your application and ensure it is live and functional.
TXT;

        $globalFocus = <<<'TXT'
We work with clients across:
United States
United Kingdom
Canada
Europe
UAE
TXT;

        $faqRows = [
            [
                'title' => 'Can you fix AI-generated code?',
                'detail' => 'Yes, we specialize in fixing and restructuring AI-generated applications into production-ready systems.',
            ],
            [
                'title' => 'Do I need to start over?',
                'detail' => 'No, we improve and stabilize your existing codebase instead of rebuilding from scratch.',
            ],
            [
                'title' => 'Can you deploy my app live?',
                'detail' => 'Yes, we handle full deployment including hosting, domains, and CI/CD pipelines.',
            ],
            [
                'title' => 'What if my project is incomplete?',
                'detail' => 'We can continue development and complete missing features.',
            ],
            [
                'title' => 'Do you support long-term scaling?',
                'detail' => 'Yes, we can evolve your app into a scalable SaaS or enterprise system.',
            ],
            [
                'title' => 'Which technologies do you support?',
                'detail' => 'We work with React, Node.js, Python, PHP, databases, APIs, and cloud platforms.',
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
                    'name' => 'AI App Rescue & Scaling',
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
                    'serviceType' => 'Application Rescue and Scaling Services',
                    'url' => 'https://www.hildes.io/ai-app-rescue',
                    'description' => 'HilDes fixes broken AI-generated applications, completes missing features, and deploys apps to production-ready scalable systems.',
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
If you’ve built an application using AI tools like ChatGPT, Cursor, Replit, or no-code platforms — but now you’re stuck with bugs, broken features, or deployment issues — HilDes helps you turn it into a fully functional, scalable product.
We specialize in repairing, restructuring, and deploying AI-generated or partially built applications so they become stable, secure, and ready for real users.
From debugging code to full production deployment, we act as your engineering team to take your idea from “almost working” to fully launched SaaS or web app.
TXT;

        $bodyContent = <<<'TXT'
AI tools have dramatically changed how software is built. Today, anyone can generate code, create UI screens, or scaffold an application within minutes. However, most of these AI-generated projects hit a critical wall: they are not production-ready.
They often contain broken logic, inconsistent architecture, missing backend connections, unstable authentication systems, or deployment issues that prevent them from being used in real environments.
At HilDes, we specialize in stepping into exactly this stage — when a project is partially built but no longer progressing.
We analyze your existing codebase, whether it is generated by AI tools, freelance developers, or internal teams, and identify the core issues blocking production readiness. Our focus is not just fixing bugs, but transforming the entire system into a clean, scalable, and maintainable architecture.
We handle both frontend and backend layers, ensuring your application is properly structured, API-connected, and optimized for performance. This includes fixing broken workflows, repairing database connections, stabilizing authentication systems, and resolving deployment failures.
A major part of our service is deployment and production setup. Many AI-built apps never go live because deployment is not properly configured. We take care of hosting, environment setup, domain configuration, and CI/CD pipelines so your application becomes accessible to real users.
We also ensure your codebase is structured for long-term growth. Instead of patching temporary fixes, we refactor and organize your system so it can evolve into a fully scalable SaaS or enterprise application.
For startups and founders, this service is often the difference between abandoning a project and successfully launching a product. We bridge that gap between AI-generated prototypes and real-world software systems.
With HilDes, you don’t need to restart your project — you just need the right engineering team to make it work, stabilize it, and take it to production.
TXT;

        $faqText = collect($faqRows)
            ->map(fn ($item, $index) => ($index + 1).'. '.$item['title'].PHP_EOL.$item['detail'])
            ->implode(PHP_EOL.PHP_EOL);

        $page = ServicePage::query()->updateOrCreate(
            ['slug' => 'ai-app-rescue'],
            [
                'name' => 'AI-Built App Rescue & Scaling Service',
                'is_published' => true,
                'hero_headline' => 'Fix, Complete & Scale Your AI-Built or Broken Application Into a Production-Ready Product',
                'hero_content' => trim($heroContent),
                'hero_image' => null,
                'body_heading' => 'From Broken Prototype to Real-World Product — Without Starting Over',
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
                'slug' => 'ai-app-rescue',
                'canonical_url' => 'https://www.hildes.io/ai-app-rescue',
                'meta_title' => 'AI App Rescue & Fix Service | Debug & Deploy AI Apps | HilDes',
                'meta_description' => 'HilDes helps fix broken AI-generated applications, debug code, complete missing features, and deploy apps to production. Turn your AI-built prototype into a scalable, working product.',
                'meta_keywords' => 'AI app fix service, fix broken AI code, deploy AI generated app, debug web applications, startup app rescue service, AI prototype to production, hire developers to fix app, web app debugging services',
                'focus_keyword' => null,
                'robots_directive' => 'index,follow',
                'og_title' => 'AI App Rescue & Scaling Service | HilDes',
                'og_description' => 'Fix, complete, and deploy your AI-built or broken application into a production-ready scalable product.',
                'og_image' => 'https://www.hildes.io/assets/og/ai-app-rescue.jpg',
                'twitter_title' => 'AI App Rescue & Scaling | HilDes',
                'twitter_description' => 'Fix broken AI-generated apps and turn them into scalable, production-ready software products.',
                'twitter_image' => 'https://www.hildes.io/assets/og/ai-app-rescue.jpg',
                'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ],
        );
    }
}
