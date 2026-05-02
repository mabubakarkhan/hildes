<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageCloudDevopsSeeder extends Seeder
{
    public function run(): void
    {
        $deliverables = <<<'TXT'
Cloud architecture design (AWS, Azure, GCP)
Application deployment & migration
CI/CD pipeline automation
Docker & Kubernetes containerization
Infrastructure as Code (Terraform, etc.)
Monitoring & logging systems
Security & compliance setup
Disaster recovery & backup solutions
Performance optimization & cost reduction
TXT;

        $process = <<<'TXT'
1. Infrastructure Assessment
We evaluate your current system or define requirements from scratch.

2. Architecture Design
We design scalable, secure, and cost-efficient cloud architecture.

3. Implementation & Deployment
We deploy applications and configure cloud environments.

4. Automation Setup
We build CI/CD pipelines and infrastructure automation systems.

5. Monitoring & Optimization
We ensure performance, uptime, and continuous improvement.
TXT;

        $globalFocus = <<<'TXT'
We serve clients across:
United States
United Kingdom
Canada
Europe
UAE
Our infrastructure solutions follow international enterprise standards for security, reliability, and scalability.
TXT;

        $faqRows = [
            [
                'title' => 'Which cloud platform do you recommend?',
                'detail' => 'We work with AWS, Azure, and Google Cloud. The choice depends on your application type, scale, and budget.',
            ],
            [
                'title' => 'Can you migrate my application to the cloud?',
                'detail' => 'Yes, we handle full cloud migration with minimal downtime and optimized architecture.',
            ],
            [
                'title' => 'What is DevOps and why is it important?',
                'detail' => 'DevOps combines development and operations to automate deployments, improve reliability, and accelerate delivery.',
            ],
            [
                'title' => 'Do you set up CI/CD pipelines?',
                'detail' => 'Yes, we build automated pipelines for faster and safer deployments.',
            ],
            [
                'title' => 'Can you reduce cloud costs?',
                'detail' => 'Yes, we optimize infrastructure to eliminate waste and improve cost efficiency.',
            ],
            [
                'title' => 'Do you provide ongoing monitoring?',
                'detail' => 'Yes, we implement monitoring systems to ensure uptime, performance, and security.',
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
                    'name' => 'Cloud & DevOps',
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
                    'serviceType' => 'Cloud Infrastructure and DevOps',
                    'url' => 'https://www.hildes.io/cloud-devops',
                    'description' => 'HilDes provides Cloud & DevOps services including AWS, Azure, GCP architecture, CI/CD pipelines, Kubernetes, Docker, and infrastructure automation for scalable systems.',
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
HilDes designs and manages secure, scalable, and automated cloud infrastructure for modern businesses. We help startups and enterprises deploy, optimize, and scale applications using AWS, Azure, and Google Cloud.
From CI/CD pipelines to full cloud architecture, we ensure your systems are fast, reliable, secure, and cost-efficient at global scale.
TXT;

        $bodyContent = <<<'TXT'
Modern software systems require more than just development — they require a robust, automated, and scalable infrastructure that ensures performance, reliability, and security under all conditions. Poorly designed infrastructure leads to downtime, high costs, slow deployments, and limited scalability.
At HilDes, we specialize in Cloud Engineering and DevOps solutions that enable businesses to deploy and scale applications with confidence. We design cloud-native architectures that are optimized for high availability, fault tolerance, and global performance.
We work with leading cloud providers including Amazon Web Services (AWS), Microsoft Azure, and Google Cloud Platform (GCP) to build infrastructure tailored to your application needs. Whether you are hosting a SaaS product, e-commerce platform, or enterprise system, we ensure your infrastructure is designed for speed, stability, and scalability.
A core part of our expertise lies in DevOps automation, where we streamline development and deployment workflows using CI/CD pipelines, containerization, and Infrastructure as Code (IaC). This reduces manual errors, accelerates release cycles, and allows your team to deploy updates faster and more reliably.
We also implement containerized environments using Docker and Kubernetes, enabling your applications to run consistently across all environments while scaling dynamically based on demand.
Security is a foundational element of everything we build. We implement industry best practices for access control, encryption, monitoring, logging, and disaster recovery, ensuring your infrastructure remains secure and compliant with global standards.
Cost optimization is another key focus. We analyze your infrastructure usage and design systems that minimize unnecessary spending while maintaining performance and reliability.
With HilDes, you are not just getting cloud setup — you are getting a fully engineered, production-grade infrastructure designed to support long-term business growth and global scalability.
TXT;

        $faqText = collect($faqRows)
            ->map(fn ($item, $index) => ($index + 1).'. '.$item['title'].PHP_EOL.$item['detail'])
            ->implode(PHP_EOL.PHP_EOL);

        $page = ServicePage::query()->updateOrCreate(
            ['slug' => 'cloud-devops'],
            [
                'name' => 'Cloud Infrastructure & DevOps',
                'is_published' => true,
                'hero_headline' => 'Scalable Cloud & DevOps Solutions for High-Performance Applications',
                'hero_content' => trim($heroContent),
                'hero_image' => null,
                'body_heading' => 'Build Infrastructure That Scales Without Limits',
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
                'slug' => 'cloud-devops',
                'canonical_url' => 'https://www.hildes.io/cloud-devops',
                'meta_title' => 'Cloud & DevOps Services Company | AWS Azure GCP Experts | HilDes',
                'meta_description' => 'HilDes provides Cloud & DevOps services including AWS, Azure, and Google Cloud architecture, CI/CD pipelines, Docker, Kubernetes, and infrastructure automation. Build scalable, secure, and high-performance systems for global businesses.',
                'meta_keywords' => 'Cloud DevOps company, AWS cloud services, Azure DevOps solutions, Google Cloud infrastructure, CI/CD pipeline setup, Kubernetes deployment, Docker DevOps services, cloud migration services',
                'focus_keyword' => null,
                'robots_directive' => 'index,follow',
                'og_title' => 'Cloud & DevOps Services | HilDes',
                'og_description' => 'Build scalable cloud infrastructure and DevOps pipelines using AWS, Azure, and Google Cloud for global businesses.',
                'og_image' => 'https://www.hildes.io/assets/og/cloud-devops.jpg',
                'twitter_title' => 'Cloud & DevOps Services | HilDes',
                'twitter_description' => 'Scalable cloud infrastructure, CI/CD pipelines, and DevOps automation for modern businesses.',
                'twitter_image' => 'https://www.hildes.io/assets/og/cloud-devops.jpg',
                'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ],
        );
    }
}
