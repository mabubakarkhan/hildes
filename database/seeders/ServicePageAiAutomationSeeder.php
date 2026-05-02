<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageAiAutomationSeeder extends Seeder
{
    public function run(): void
    {
        $deliverables = <<<'TXT'
AI chatbots for websites and applications
AI voice agents for customer support & sales
Workflow automation systems
CRM & third-party AI integrations
Lead qualification & sales automation
Internal business process automation
LLM-powered intelligent assistants
API-based AI system integration
TXT;

        $process = <<<'TXT'
1. Business Process Analysis
We identify workflows that can be automated using AI.

2. AI System Design
We design intelligent workflows and agent architecture.

3. Development & Integration
We build AI agents and integrate them into your systems.

4. Testing & Optimization
We validate accuracy, performance, and reliability.

5. Deployment & Continuous Improvement
We deploy AI systems and improve them based on real usage.
TXT;

        $globalFocus = <<<'TXT'
We build AI systems for businesses targeting:
United States
United Kingdom
Canada
Europe
UAE
Our AI solutions are designed to meet global standards of reliability, scalability, and performance.
TXT;

        $faqRows = [
            [
                'title' => 'What is AI automation?',
                'detail' => 'AI automation uses artificial intelligence to perform tasks such as customer support, data processing, and workflow execution without human intervention.',
            ],
            [
                'title' => 'What are AI agents?',
                'detail' => 'AI agents are intelligent systems that can interact with users, process information, and take actions automatically based on defined goals.',
            ],
            [
                'title' => 'Can AI replace customer support teams?',
                'detail' => 'AI can handle a large percentage of repetitive queries, significantly reducing workload and improving response times, but human support is still needed for complex cases.',
            ],
            [
                'title' => 'Do you build custom AI solutions?',
                'detail' => 'Yes, all AI systems are custom-built based on your business workflows and requirements.',
            ],
            [
                'title' => 'Can AI integrate with my existing systems?',
                'detail' => 'Yes, we integrate AI with CRMs, websites, mobile apps, and third-party APIs.',
            ],
            [
                'title' => 'How long does it take to build an AI system?',
                'detail' => 'Simple systems can take 2–4 weeks, while advanced AI automation platforms may take longer depending on complexity.',
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
                    'name' => 'AI Automation & AI Agents',
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
                    'serviceType' => 'AI Automation and AI Agents Development',
                    'url' => 'https://www.hildes.io/ai-automation',
                    'description' => 'HilDes builds AI automation systems, chatbots, and voice agents that help businesses automate workflows, reduce costs, and improve operational efficiency.',
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
HilDes builds production-ready AI automation systems, chatbots, and voice agents that help businesses reduce costs, automate workflows, and scale operations intelligently.
We design AI systems that go beyond simple chatbots — delivering real business automation, customer interaction handling, and workflow intelligence for companies across the US, UK, Europe, and UAE.
TXT;

        $bodyContent = <<<'TXT'
Artificial Intelligence is no longer a future concept — it is now a core operational layer for modern businesses. Companies that integrate AI into their workflows are reducing operational costs, improving customer experience, and scaling faster than their competitors.
At HilDes, we specialize in building real-world AI automation systems and intelligent agents that solve actual business problems, not experimental prototypes or generic chatbots.
We design and develop AI-powered systems that can handle customer support, lead qualification, sales assistance, internal workflows, and data processing tasks with minimal human intervention. These systems are built to operate 24/7, improving response times and ensuring consistent service delivery across all channels.
Our AI solutions include chat-based agents, voice assistants, and workflow automation engines that integrate directly into your existing systems such as CRMs, websites, mobile apps, and internal tools. This ensures a seamless flow of data and actions across your business ecosystem.
We leverage modern AI technologies including natural language processing (NLP), large language models (LLMs), and API-based automation systems to create intelligent workflows that adapt and improve over time. Unlike basic automation tools, our systems are tailored specifically to your business logic and operational requirements.
A key focus of our approach is business process automation, where we identify repetitive, time-consuming tasks and convert them into intelligent automated workflows. This includes customer support responses, ticket handling, appointment scheduling, data entry, reporting, and more.
We also build AI voice agents capable of handling inbound and outbound calls, providing human-like interactions while maintaining accuracy and efficiency. These systems can significantly reduce the need for large support or sales teams while improving response quality.
Security, reliability, and scalability are core principles in every AI system we build. We ensure that your data is protected, your workflows are stable, and your AI systems can handle increasing workloads without performance degradation.
With HilDes, you are not just adopting AI tools — you are implementing a fully integrated automation layer that transforms your business into a scalable, intelligent system.
TXT;

        $faqText = collect($faqRows)
            ->map(fn ($item, $index) => ($index + 1).'. '.$item['title'].PHP_EOL.$item['detail'])
            ->implode(PHP_EOL.PHP_EOL);

        $page = ServicePage::query()->updateOrCreate(
            ['slug' => 'ai-automation'],
            [
                'name' => 'AI Automation & AI Agents',
                'is_published' => true,
                'hero_headline' => 'AI Automation & Intelligent Agents That Transform How Your Business Operates',
                'hero_content' => trim($heroContent),
                'hero_image' => null,
                'body_heading' => 'Turn Your Business Into an Intelligent, Automated System',
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
                'slug' => 'ai-automation',
                'canonical_url' => 'https://www.hildes.io/ai-automation',
                'meta_title' => 'AI Automation & AI Agents Development Company | HilDes',
                'meta_description' => 'HilDes builds AI automation systems, chatbots, and voice agents for businesses. Automate workflows, reduce costs, and scale operations with custom AI solutions built for global companies.',
                'meta_keywords' => 'AI automation company, AI agents development, AI chatbot development, workflow automation AI, voice AI agents, business automation solutions, AI integration services, custom AI development',
                'focus_keyword' => null,
                'robots_directive' => 'index,follow',
                'og_title' => 'AI Automation & AI Agents Development | HilDes',
                'og_description' => 'Build intelligent AI systems, chatbots, and automation workflows that transform business operations and reduce costs.',
                'og_image' => 'https://www.hildes.io/assets/og/ai-automation.jpg',
                'twitter_title' => 'AI Automation & AI Agents | HilDes',
                'twitter_description' => 'Build AI chatbots, voice agents, and automation systems that transform business operations and scale efficiency.',
                'twitter_image' => 'https://www.hildes.io/assets/og/ai-automation.jpg',
                'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ],
        );
    }
}
