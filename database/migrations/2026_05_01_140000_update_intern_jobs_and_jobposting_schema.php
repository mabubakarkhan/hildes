<?php

use App\Models\Job;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $jobsConfig = [
            'bdm-intern-may-2026' => [
                'occupationalCategory' => 'Business Development',
                'industry' => 'Information Technology & Services',
                'description_append' => '<p><strong>What you will learn:</strong> Pipeline research, outreach messaging, CRM hygiene, and how BD supports AI, SaaS, and MVP engagements at HilDes.</p>',
            ],
            'digital-marketing-intern-may-2026' => [
                'occupationalCategory' => 'Marketing',
                'industry' => 'Information Technology & Services',
                'description_append' => '<p><strong>What you will learn:</strong> Organic growth tactics, campaign reporting, on-page SEO checks, and content workflows for technology products.</p>',
            ],
        ];

        foreach ($jobsConfig as $slug => $cfg) {
            $job = Job::query()->where('slug', $slug)->first();
            if (! $job) {
                continue;
            }

            $baseDescription = (string) $job->description;
            if (! str_contains($baseDescription, 'What you will learn')) {
                $job->update([
                    'description' => $baseDescription.$cfg['description_append'],
                ]);
                $job->refresh();
            }

            $plainDescription = $this->plainTextForSchema($job);
            $qualifications = $this->joinPlainParts([
                $job->education_requirements,
                $job->required_skills,
            ]);
            $responsibilitiesPlain = trim(strip_tags((string) $job->responsibilities));

            $datePosted = $job->published_at
                ? $job->published_at->toIso8601String()
                : $job->updated_at->toIso8601String();

            $validThrough = $job->deadline
                ? $job->deadline->format('Y-m-d').'T23:59:59Z'
                : null;

            $jobPosting = [
                '@context' => 'https://schema.org',
                '@type' => 'JobPosting',
                'title' => $job->title,
                'description' => Str::limit($plainDescription, 10000),
                'identifier' => [
                    '@type' => 'PropertyValue',
                    'name' => 'HilDes',
                    'value' => $job->slug,
                ],
                'url' => 'https://www.hildes.io/careers#'.$job->slug,
                'datePosted' => $datePosted,
                'employmentType' => 'INTERN',
                'hiringOrganization' => [
                    '@type' => 'Organization',
                    'name' => 'HilDes',
                    'sameAs' => 'https://www.hildes.io',
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => 'https://www.hildes.io/logo.png',
                    ],
                ],
                'jobLocation' => [
                    '@type' => 'Place',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressCountry' => 'PK',
                        'streetAddress' => (string) $job->location,
                    ],
                ],
                'industry' => $cfg['industry'],
                'occupationalCategory' => $cfg['occupationalCategory'],
                'workHours' => 'Mo,Tu,We,Th,Fr 10:00-16:00',
                'qualifications' => Str::limit($qualifications, 5000),
                'responsibilities' => Str::limit($responsibilitiesPlain, 5000),
                'skills' => trim(strip_tags((string) $job->required_skills)),
            ];

            if ($validThrough !== null) {
                $jobPosting['validThrough'] = $validThrough;
            }

            $schemaJson = json_encode($jobPosting, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            DB::table('seo_metas')
                ->where('seoable_type', Job::class)
                ->where('seoable_id', $job->id)
                ->update([
                    'schema_json' => $schemaJson,
                    'og_type' => 'website',
                    'canonical_url' => 'https://www.hildes.io/careers#'.$job->slug,
                    'og_url' => 'https://www.hildes.io/careers#'.$job->slug,
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        foreach (['bdm-intern-may-2026', 'digital-marketing-intern-may-2026'] as $slug) {
            $job = Job::query()->where('slug', $slug)->first();
            if (! $job) {
                continue;
            }

            DB::table('seo_metas')
                ->where('seoable_type', Job::class)
                ->where('seoable_id', $job->id)
                ->update([
                    'schema_json' => null,
                    'canonical_url' => 'https://www.hildes.io/careers/'.$slug,
                    'og_url' => 'https://www.hildes.io/careers/'.$slug,
                    'updated_at' => now(),
                ]);
        }
    }

    private function plainTextForSchema(Job $job): string
    {
        $parts = [
            $job->description,
            $job->responsibilities,
            $job->education_requirements,
            $job->required_skills,
        ];

        return $this->joinPlainParts($parts);
    }

    private function joinPlainParts(array $parts): string
    {
        $out = [];
        foreach ($parts as $part) {
            $t = trim(preg_replace('/\s+/', ' ', strip_tags((string) $part)));
            if ($t !== '') {
                $out[] = $t;
            }
        }

        return implode("\n\n", $out);
    }
};
