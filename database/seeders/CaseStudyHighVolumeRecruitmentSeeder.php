<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use Illuminate\Database\Seeder;

class CaseStudyHighVolumeRecruitmentSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            'overview' => '<p>HilDes partnered with a recruitment agency to build a high-performance job portal designed to generate and process large volumes of qualified applicants through paid acquisition channels.</p><p>The platform manages the entire applicant lifecycle, including:</p><ul><li>Ad click to landing page to application submission</li><li>Applicant tracking and management</li><li>Lead deduplication and validation</li><li>Source attribution and performance reporting</li></ul><p>The primary goal was to create a scalable recruitment engine capable of handling high daily traffic and consistent lead generation from Google Ads and remarketing campaigns.</p>',
            'challenge' => '<p>The client needed more than just a job portal — they needed a performance-driven system tightly integrated with paid marketing funnels.</p><p><strong>Key challenges:</strong></p><ul><li>Handling high traffic volume from Google Ads campaigns</li><li>Ensuring fast load times for conversion optimization</li><li>Eliminating duplicate or low-quality applications</li><li>Tracking accurate attribution from ad to submission</li><li>Scaling infrastructure to support growing campaign volume</li><li>Maintaining consistent environments across development and production</li></ul>',
            'approach' => '<p>We designed the platform as a conversion-focused recruitment funnel and scalable backend system, combining:</p><ul><li>Performance-optimized frontend for high conversions</li><li>Smart backend logic for filtering and deduplication</li><li>Deep integration with Google Ads API</li><li>Cloud-native infrastructure for scalability</li></ul>',
            'infrastructure' => '<p><strong>Conversion funnel design flow:</strong></p><ol><li>Google Ads and remarketing campaigns</li><li>Optimized landing pages</li><li>Application submission forms</li><li>Backend processing and filtering</li><li>Applicant dashboard and reporting</li></ol><p><strong>AWS infrastructure setup:</strong></p><ul><li>Application Load Balancer (ALB) for traffic distribution</li><li>Dockerized application deployed on EC2 instances</li><li>Auto-scaling ready architecture</li><li>Amazon RDS (MySQL) for managed database</li><li>S3 storage for assets and logs</li><li>Secure networking and IAM configuration</li></ul><p><strong>Benefits:</strong> horizontal scalability, high availability, environment consistency, and strong performance under spikes.</p>',
            'stabilization' => '<p><strong>Core stack:</strong></p><ul><li>PHP / CodeIgniter</li><li>MySQL</li><li>JavaScript / jQuery</li><li>Docker</li><li>AWS cloud infrastructure</li><li>Google Ads API</li></ul><p><strong>Engineering approach:</strong></p><ul><li>Modular backend architecture</li><li>Optimized database queries</li><li>Lightweight frontend for faster load times</li></ul>',
            'devops' => '<p><strong>Dockerized deployment implementation:</strong></p><ul><li>Fully containerized application using Docker</li><li>Consistent dev, staging, and production environments</li><li>Simplified deployment and scaling</li></ul><p><strong>Impact:</strong></p><ul><li>Eliminated environment inconsistencies</li><li>Faster deployment cycles</li><li>Easier scaling and maintenance</li></ul>',
            'quality' => '<p><strong>Google Ads and remarketing integration:</strong></p><ul><li>Integrated Google Ads API for campaign-level data</li><li>Tracked user journey from ad click to submission</li><li>Implemented remarketing logic for re-engagement</li><li>Enabled automated lead tracking and attribution</li></ul><p><strong>Impact:</strong> clear visibility into campaign performance, improved ROI, and better budget allocation.</p>',
            'process' => '<p><strong>Reporting and analytics dashboard features:</strong></p><ul><li>Daily applicant volume tracking</li><li>Source attribution (campaign-level insights)</li><li>Conversion rate analysis</li><li>Performance trends over time</li></ul><p><strong>Outcome:</strong> real-time recruitment visibility, data-driven decisions, and better campaign optimization.</p>',
            'security' => '<p><strong>Applicant deduplication and quality filtering:</strong></p><p>High-volume campaigns often generate duplicate or low-quality leads.</p><p><strong>Solution:</strong></p><ul><li>Intelligent deduplication system</li><li>Email + phone + session-based filtering</li><li>Logic to flag and remove duplicate submissions</li><li>Basic quality scoring system</li></ul><p><strong>Impact:</strong> cleaner applicant database, lower manual effort, and higher quality candidates.</p>',
            'performance' => '<p><strong>Performance optimization focus areas:</strong></p><ul><li>Fast-loading landing pages</li><li>Optimized database queries</li><li>Efficient backend processing</li><li>CDN and caching strategies</li></ul><p><strong>Results:</strong></p><ul><li>Sub-second page load times</li><li>Higher conversion rates</li><li>Stable performance under high traffic</li></ul>',
            'modernization' => '<p><strong>Deliverables:</strong></p><ul><li>End-to-end job portal with applicant tracking</li><li>Google Ads and remarketing API integration</li><li>Applicant deduplication and filtering system</li><li>Dockerized deployment on AWS</li><li>Reporting dashboard with analytics and attribution</li><li>Scalable cloud infrastructure</li></ul>',
            'results' => '<ul><li>400+ qualified applicants per day</li><li>Accurate campaign attribution and tracking</li><li>High-performance platform under heavy traffic</li><li>Automated lead processing and filtering</li><li>Scalable infrastructure ready for growth</li></ul>',
            'outcome' => '<p>The client now operates a high-volume recruitment engine capable of generating, processing, and analyzing applicant data at scale — turning paid traffic into consistent, measurable hiring outcomes.</p>',
        ];

        $slug = 'high-volume-recruitment-job-portal';
        $nextOrder = ((int) CaseStudy::query()->max('display_order')) + 1;

        $caseStudy = CaseStudy::query()->updateOrCreate(
            ['slug' => $slug],
            [
                'title' => 'High-Volume Recruitment Job Portal',
                'slug' => $slug,
                'tagline' => 'Generating 400+ Qualified Applicants Daily with a Scalable, Conversion-Driven System',
                'short_description' => 'HilDes built a high-performance recruitment portal integrated with Google Ads and remarketing to generate and process 400+ qualified applicants daily with attribution and scalable cloud operations.',
                'sections_json' => $sections,
                'is_published' => true,
                'display_order' => $nextOrder,
            ]
        );

        $caseStudy->seoMeta()->updateOrCreate(
            [],
            [
                'seo_enabled' => true,
                'is_indexable' => true,
                'include_in_sitemap' => true,
                'slug' => $caseStudy->slug,
                'canonical_url' => url('/case-studies/'.$caseStudy->slug),
                'meta_title' => 'High-Volume Recruitment Job Portal Case Study | HilDes',
                'meta_description' => 'Discover how HilDes delivered a conversion-driven recruitment platform generating 400+ qualified applicants daily with scalable cloud architecture.',
                'meta_keywords' => 'job portal case study, recruitment platform, google ads integration, applicant tracking, lead deduplication, hildes',
                'focus_keyword' => 'high volume recruitment job portal case study',
                'robots_directive' => 'index,follow',
                'og_title' => 'High-Volume Recruitment Job Portal | Case Study',
                'og_description' => 'A scalable recruitment engine for high-volume applicant generation and campaign attribution.',
                'twitter_title' => 'High-Volume Recruitment Job Portal | HilDes',
                'twitter_description' => 'Case study: 400+ qualified applicants daily with a scalable conversion-driven platform.',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'Article',
                            'headline' => 'High-Volume Recruitment Job Portal',
                            'description' => 'Case study of building a scalable recruitment job portal and paid funnel integration.',
                            'author' => [
                                '@type' => 'Organization',
                                'name' => 'HilDes',
                            ],
                        ],
                    ],
                ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ]
        );
    }
}

