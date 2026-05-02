<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageMobileAppDevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        $deliverables = <<<'TXT'
iOS & Android mobile app development
Cross-platform app development (React Native / Flutter)
MVP mobile app development
UI/UX design for mobile applications
Backend & API integration
Real-time features (chat, notifications, live data)
Third-party integrations (payments, analytics, etc.)
App performance optimization
Secure authentication systems
App deployment to App Store & Google Play
TXT;

        $process = <<<'TXT'
1. Product Strategy & Planning
We define app goals, users, and features.

2. UI/UX Design
We design intuitive and engaging mobile experiences.

3. Development
We build scalable and high-performance mobile applications.

4. Integration & Testing
We connect backend systems and ensure reliability.

5. Launch & Optimization
We deploy your app and continuously improve performance.
TXT;

        $globalFocus = <<<'TXT'
We build mobile applications for clients across:
United States
United Kingdom
Canada
Europe
UAE
Our apps follow international standards for performance, usability, and security.
TXT;

        $faqText = <<<'TXT'
1. Do you build both iOS and Android apps?
Yes, we develop apps for both platforms using native and cross-platform technologies.

2. Which technology do you recommend?
It depends on your goals. We recommend React Native or Flutter for speed and native for performance-critical apps.

3. Can you build an MVP mobile app?
Yes, we specialize in MVP apps for startups to validate ideas quickly.

4. Do you handle backend development?
Yes, we build complete systems including backend APIs and cloud infrastructure.

5. Will my app be scalable?
Yes, we design apps with scalable architecture for future growth.

6. Do you publish apps to stores?
Yes, we handle deployment to Apple App Store and Google Play Store.
TXT;

        $faqRows = [
            [
                'title' => 'Do you build both iOS and Android apps?',
                'detail' => 'Yes, we develop apps for both platforms using native and cross-platform technologies.',
            ],
            [
                'title' => 'Which technology do you recommend?',
                'detail' => 'It depends on your goals. We recommend React Native or Flutter for speed and native for performance-critical apps.',
            ],
            [
                'title' => 'Can you build an MVP mobile app?',
                'detail' => 'Yes, we specialize in MVP apps for startups to validate ideas quickly.',
            ],
            [
                'title' => 'Do you handle backend development?',
                'detail' => 'Yes, we build complete systems including backend APIs and cloud infrastructure.',
            ],
            [
                'title' => 'Will my app be scalable?',
                'detail' => 'Yes, we design apps with scalable architecture for future growth.',
            ],
            [
                'title' => 'Do you publish apps to stores?',
                'detail' => 'Yes, we handle deployment to Apple App Store and Google Play Store.',
            ],
        ];

        $schemaGraph = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Service',
                    'name' => 'Mobile App Development',
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
                    'serviceType' => 'Mobile Application Development',
                    'url' => 'https://www.hildes.io/mobile-app-development',
                    'description' => 'HilDes provides mobile app development services for iOS and Android, building scalable, secure, and high-performance applications for startups and enterprises.',
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
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'Do you develop both iOS and Android apps?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Yes, we build mobile applications for both iOS and Android platforms using native and cross-platform technologies.',
                            ],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Can you build MVP mobile apps?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Yes, we specialize in MVP development for startups to validate ideas quickly.',
                            ],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Do you handle app deployment?',
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => 'Yes, we manage deployment to Apple App Store and Google Play Store.',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $heroContent = <<<'TXT'
HilDes builds fast, scalable, and user-focused mobile applications for startups and enterprises. From MVP apps to full-scale platforms, we design and develop iOS and Android applications that deliver seamless user experiences and strong business results.
We specialize in building apps that are reliable, secure, and ready to scale globally.
TXT;

        $bodyContent = <<<'TXT'
Mobile applications have become a critical part of modern digital ecosystems. However, building a successful mobile app requires more than just development - it requires a deep understanding of user behavior, performance optimization, and scalable architecture.
At HilDes, we focus on creating mobile applications that are not only visually appealing but also highly functional and performance-driven. Every app we build is designed with a clear objective: to deliver a smooth user experience while supporting long-term business growth.
We work with startups and businesses to transform ideas into production-ready mobile applications, starting from concept validation to final deployment. Our development process ensures that your app is structured correctly from day one, reducing future technical debt and enabling scalability.
Our expertise includes both cross-platform and native mobile development, allowing us to build applications that perform efficiently across devices while maintaining a consistent user experience.
We also focus heavily on backend integration and API connectivity, ensuring that your mobile application works seamlessly with your web systems, cloud infrastructure, and third-party services.
Performance is a key priority. We optimize applications for fast loading times, smooth navigation, and efficient data handling, ensuring that users remain engaged and satisfied.
Security is another critical component. We implement best practices for authentication, data protection, and secure API communication, ensuring that your application is safe and compliant with modern standards.
Beyond development, we help you plan for growth by building apps that can evolve into full-scale platforms, whether that means integrating advanced features, scaling infrastructure, or expanding to new markets.
With HilDes, you are not just building a mobile app - you are building a scalable digital product designed for real-world success.
TXT;

        $page = ServicePage::query()->updateOrCreate(
            ['slug' => 'mobile-app-development'],
            [
                'name' => 'Mobile App Development',
                'is_published' => true,
                'hero_headline' => 'High-Performance Mobile App Development for Scalable Digital Products',
                'hero_content' => trim($heroContent),
                'body_heading' => 'Build Mobile Apps That Users Love and Businesses Grow With',
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
                'slug' => 'mobile-app-development',
                'canonical_url' => 'https://www.hildes.io/mobile-app-development',
                'meta_title' => 'Mobile App Development Company | iOS & Android Apps | HilDes',
                'meta_description' => 'HilDes provides mobile app development services for iOS and Android. We build scalable, high-performance mobile applications with modern technologies, seamless UX, and global deployment readiness.',
                'meta_keywords' => 'mobile app development company, iOS app development, Android app developers, React Native app development, Flutter app development, mobile app agency, custom mobile apps, startup app development',
                'focus_keyword' => null,
                'robots_directive' => 'index,follow',
                'og_title' => 'Mobile App Development Services | HilDes',
                'og_description' => 'Build scalable and high-performance mobile apps for iOS and Android with expert development and modern technologies.',
                'og_image' => 'https://www.hildes.io/assets/og/mobile-app-development.jpg',
                'twitter_title' => 'Mobile App Development Services | HilDes',
                'twitter_description' => 'Custom mobile app development for iOS and Android designed for performance, scalability, and user experience.',
                'twitter_image' => 'https://www.hildes.io/assets/og/mobile-app-development.jpg',
                'schema_json' => json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ],
        );
    }
}
