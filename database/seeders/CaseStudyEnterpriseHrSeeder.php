<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use Illuminate\Database\Seeder;

class CaseStudyEnterpriseHrSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            'overview' => <<<HTML
<p>We partnered with a growing organization operating a comprehensive People Management Platform that included:</p>
<ul>
  <li>Applicant Tracking System (ATS)</li>
  <li>Time-off and Attendance Management</li>
  <li>Learning Management System (LMS)</li>
  <li>Employee Lifecycle Management (Onboarding/Offboarding)</li>
  <li>Document Management System</li>
</ul>
<p>Despite having strong business potential, the platform was facing critical system failures, performance issues, and infrastructure instability, making it unreliable for daily operations.</p>
HTML,
            'challenge' => <<<HTML
<p>The system had reached a point where it was no longer sustainable or scalable.</p>
<p><strong>Key issues identified:</strong></p>
<ul>
  <li>Frequent application crashes and unexpected downtime</li>
  <li>Extremely slow performance (30–180 seconds response time under load)</li>
  <li>Poorly structured and unmaintainable codebase</li>
  <li>No version control (no Git usage)</li>
  <li>Manual deployments with high failure risk</li>
  <li>No staging environment</li>
  <li>AWS infrastructure misconfigured</li>
  <li>Database, backups, and server hosted on a single EC2 instance</li>
  <li>Backup failures with no validation strategy</li>
  <li>No monitoring or alerting systems</li>
  <li>Vulnerability to DDoS attacks</li>
  <li>No defined SDLC or development workflow</li>
</ul>
<p><strong>This resulted in:</strong></p>
<ul>
  <li>Operational disruptions</li>
  <li>Loss of user trust</li>
  <li>Increased technical debt</li>
  <li>High risk of data loss</li>
</ul>
HTML,
            'approach' => <<<HTML
<p>We approached this as a full system recovery and modernization project, focusing on:</p>
<ul>
  <li>Infrastructure redesign</li>
  <li>Codebase stabilization</li>
  <li>DevOps implementation</li>
  <li>Performance optimization</li>
  <li>Security hardening</li>
  <li>Scalable architecture planning</li>
</ul>
HTML,
            'infrastructure' => <<<HTML
<p><strong>Old architecture (single point of failure):</strong></p>
<p>Single EC2 instance handling application, database, backups, and background jobs.</p>
<p><strong>Problems:</strong></p>
<ul>
  <li>No scalability</li>
  <li>High downtime risk</li>
  <li>Resource contention</li>
  <li>Backup failures</li>
  <li>No fault tolerance</li>
</ul>
<p><strong>New scalable AWS architecture:</strong></p>
<ul>
  <li>Application Load Balancer (ALB)</li>
  <li>Multiple EC2 instances (Auto Scaling ready)</li>
  <li>Amazon RDS (managed database)</li>
  <li>Separate backup systems</li>
  <li>Secure networking and IAM roles</li>
</ul>
<p><strong>Results:</strong></p>
<ul>
  <li>Eliminated single point of failure</li>
  <li>Improved uptime and reliability</li>
  <li>Horizontal scalability enabled</li>
  <li>Database performance significantly improved</li>
</ul>
HTML,
            'stabilization' => <<<HTML
<p><strong>Problems:</strong></p>
<ul>
  <li>Messy, unstructured code</li>
  <li>No environment consistency</li>
  <li>Difficult debugging</li>
</ul>
<p><strong>Fixes:</strong></p>
<ul>
  <li>Containerized application using Docker</li>
  <li>Standardized local development environments</li>
  <li>Refactored critical modules for stability</li>
  <li>Introduced modular architecture</li>
</ul>
<p><strong>Impact:</strong></p>
<ul>
  <li>Faster onboarding for developers</li>
  <li>Reduced bugs caused by environment mismatch</li>
  <li>Improved maintainability</li>
</ul>
HTML,
            'devops' => <<<HTML
<p><strong>Problems:</strong></p>
<ul>
  <li>No Git</li>
  <li>Manual deployments</li>
  <li>No rollback mechanism</li>
</ul>
<p><strong>Fixes:</strong></p>
<ul>
  <li>Migrated codebase to Git (version control)</li>
  <li>Introduced branching strategy (dev / staging / production)</li>
  <li>Implemented CI/CD pipelines using Jenkins</li>
  <li>Added staging environment before production</li>
</ul>
<p><strong>Impact:</strong></p>
<ul>
  <li>Safe and repeatable deployments</li>
  <li>Faster release cycles</li>
  <li>Reduced human error</li>
</ul>
HTML,
            'quality' => <<<HTML
<p><strong>Problems:</strong></p>
<ul>
  <li>No code quality checks</li>
  <li>High technical debt</li>
</ul>
<p><strong>Fixes:</strong></p>
<ul>
  <li>Integrated SonarQube and SonarLint</li>
  <li>Enforced code quality rules</li>
  <li>Added static code analysis</li>
</ul>
<p><strong>Impact:</strong></p>
<ul>
  <li>Improved code reliability</li>
  <li>Reduced production bugs</li>
  <li>Better long-term scalability</li>
</ul>
HTML,
            'process' => <<<HTML
<p><strong>Problems:</strong></p>
<ul>
  <li>No structured development workflow</li>
  <li>Poor task tracking</li>
</ul>
<p><strong>Fixes:</strong></p>
<ul>
  <li>Introduced Agile methodology</li>
  <li>Sprint-based development cycles</li>
  <li>Implemented project management tools (Jira/ClickUp)</li>
  <li>Defined SDLC lifecycle</li>
</ul>
<p><strong>Impact:</strong></p>
<ul>
  <li>Clear development roadmap</li>
  <li>Improved team productivity</li>
  <li>Better delivery timelines</li>
</ul>
HTML,
            'security' => <<<HTML
<p><strong>Problems:</strong></p>
<ul>
  <li>DDoS vulnerability</li>
  <li>No monitoring</li>
  <li>Backup failures</li>
</ul>
<p><strong>Fixes:</strong></p>
<ul>
  <li>Implemented AWS security best practices</li>
  <li>Configured firewalls and rate limiting</li>
  <li>Set up monitoring and alerting systems</li>
  <li>Introduced backup validation strategy (bi-monthly testing)</li>
  <li>Added local backup redundancy</li>
</ul>
<p><strong>Impact:</strong></p>
<ul>
  <li>Improved system security</li>
  <li>Early issue detection</li>
  <li>Reliable disaster recovery</li>
</ul>
HTML,
            'performance' => <<<HTML
<p><strong>Problems:</strong></p>
<ul>
  <li>30s–180s response time</li>
  <li>Poor performance under load</li>
</ul>
<p><strong>Fixes:</strong></p>
<ul>
  <li>Optimized database queries</li>
  <li>Moved DB to Amazon RDS</li>
  <li>Implemented caching strategies</li>
  <li>Optimized backend processing</li>
  <li>Load-balanced traffic</li>
</ul>
<p><strong>Results:</strong></p>
<ul>
  <li>Response time reduced from 30–180s to less than 2s</li>
  <li>Significant improvement in user experience</li>
  <li>Stable performance under peak load</li>
</ul>
HTML,
            'modernization' => <<<HTML
<p><strong>Improvements:</strong></p>
<ul>
  <li>Introduced modern tech stack for new modules</li>
  <li>Built system for incremental upgrades</li>
  <li>Decoupled legacy dependencies</li>
</ul>
<p><strong>Impact:</strong></p>
<ul>
  <li>Future-ready architecture</li>
  <li>Easier feature expansion</li>
  <li>Reduced technical debt</li>
</ul>
HTML,
            'results' => <<<HTML
<ul>
  <li>99.9% uptime achieved</li>
  <li>Response time improved by over 90%</li>
  <li>Secure and stable infrastructure</li>
  <li>Scalable cloud architecture</li>
  <li>Automated deployment pipeline</li>
  <li>Structured development workflow</li>
  <li>Reliable backup and recovery system</li>
</ul>
HTML,
            'outcome' => <<<HTML
<p>The platform evolved from an unstable system into a mission-critical, enterprise-grade HR solution capable of supporting real-time operations and scaling with business growth.</p>
HTML,
        ];

        $caseStudy = CaseStudy::query()->updateOrCreate(
            ['slug' => 'enterprise-hr-platform-stabilization-and-scaling'],
            [
                'title' => 'Enterprise HR Platform Stabilization & Scaling',
                'slug' => 'enterprise-hr-platform-stabilization-and-scaling',
                'tagline' => 'Transforming a failing HR system into a scalable, high-performance platform',
                'short_description' => 'We stabilized and modernized an enterprise HR platform by redesigning AWS infrastructure, implementing CI/CD, enforcing code quality, and optimizing performance from 30–180s to <2s response times.',
                'sections_json' => $sections,
                'is_published' => true,
                'display_order' => 1,
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
                'meta_title' => 'Enterprise HR Platform Stabilization & Scaling Case Study | HilDes',
                'meta_description' => 'See how HilDes transformed a failing enterprise HR platform into a secure, scalable, high-performance system with 99.9% uptime and sub-2s response times.',
                'meta_keywords' => 'enterprise HR case study, platform stabilization, AWS scaling, DevOps case study, CI CD implementation, performance optimization, HilDes',
                'focus_keyword' => 'enterprise hr platform stabilization case study',
                'robots_directive' => 'index,follow',
                'og_title' => 'Enterprise HR Platform Stabilization & Scaling | Case Study',
                'og_description' => 'From instability to enterprise-grade reliability: infrastructure redesign, DevOps pipelines, security hardening, and major performance gains.',
                'twitter_title' => 'Enterprise HR Platform Stabilization & Scaling | HilDes',
                'twitter_description' => 'A real transformation case study: 99.9% uptime, better security, automated delivery, and response time reduced to <2s.',
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'Article',
                            'headline' => 'Enterprise HR Platform Stabilization & Scaling',
                            'description' => 'Case study of stabilizing and scaling a failing enterprise HR platform.',
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

