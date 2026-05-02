<?php

use App\Models\Job;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $scheduleNote = '<p><strong>Working hours:</strong> 10:00 AM – 4:00 PM (6 hours per day), Monday to Friday.</p>';
        $applyNote = '<p><strong>Apply by:</strong> 30 May 2026.</p>';

        $definitions = [
            [
                'title' => 'BDM Intern',
                'slug' => 'bdm-intern-may-2026',
                'department' => 'Business Development',
                'employment_type' => 'Internship',
                'location' => 'Hybrid (as agreed)',
                'work_mode' => 'Hybrid',
                'experience_level' => 'Intern / Fresher',
                'min_experience_years' => 0,
                'max_experience_years' => 1,
                'education_requirements' => 'Pursuing or completed a bachelor\'s degree in Business Administration, Marketing, Commerce, or a related field.',
                'required_skills' => 'Strong communication and interpersonal skills; comfortable with email and phone outreach; MS Excel / Google Sheets; curiosity about B2B sales and partnerships; organized and detail-oriented.',
                'responsibilities' => 'Support lead research and list building; assist with CRM updates and follow-ups; help prepare decks and meeting notes; shadow calls and demos where appropriate; contribute to partner and client outreach campaigns under supervision.',
                'description' => $scheduleNote.$applyNote.'<p>Join HilDes as a Business Development intern and learn how we position AI, SaaS, and MVP offerings to clients. You will work closely with senior BD team members on pipeline hygiene, outreach sequences, and market mapping.</p>',
                'salary_range' => 'Stipend (discussed at interview)',
                'meta_title' => 'BDM Intern | HilDes',
                'meta_description' => 'Business development internship at HilDes. 6-hour day (10 AM–4 PM). Apply by 30 May 2026.',
                'focus_keyword' => 'BDM intern',
            ],
            [
                'title' => 'Digital Marketing Intern',
                'slug' => 'digital-marketing-intern-may-2026',
                'department' => 'Marketing',
                'employment_type' => 'Internship',
                'location' => 'Hybrid (as agreed)',
                'work_mode' => 'Hybrid',
                'experience_level' => 'Intern / Fresher',
                'min_experience_years' => 0,
                'max_experience_years' => 1,
                'education_requirements' => 'Pursuing or completed a bachelor\'s in Marketing, Communications, Media, or a related field.',
                'required_skills' => 'Basic understanding of SEO, social media, and content formats; familiarity with Canva or similar tools; good writing in English; willingness to learn analytics and campaign reporting.',
                'responsibilities' => 'Assist with social content scheduling and drafts; support on-page SEO checks and content updates; help track campaign metrics; contribute to email and landing page copy reviews; support event and launch announcements.',
                'description' => $scheduleNote.$applyNote.'<p>Support HilDes marketing across organic channels, campaigns, and brand touchpoints for AI, SaaS, and software services. Ideal if you want hands-on experience with modern growth stacks.</p>',
                'salary_range' => 'Stipend (discussed at interview)',
                'meta_title' => 'Digital Marketing Intern | HilDes',
                'meta_description' => 'Digital marketing internship at HilDes. 6-hour day (10 AM–4 PM). Apply by 30 May 2026.',
                'focus_keyword' => 'digital marketing intern',
            ],
        ];

        $now = now();

        foreach ($definitions as $def) {
            if (Job::query()->where('slug', $def['slug'])->exists()) {
                continue;
            }

            $job = Job::query()->create([
                'title' => $def['title'],
                'slug' => $def['slug'],
                'department' => $def['department'],
                'employment_type' => $def['employment_type'],
                'location' => $def['location'],
                'work_mode' => $def['work_mode'],
                'experience_level' => $def['experience_level'],
                'min_experience_years' => $def['min_experience_years'],
                'max_experience_years' => $def['max_experience_years'],
                'education_requirements' => $def['education_requirements'],
                'required_skills' => $def['required_skills'],
                'responsibilities' => $def['responsibilities'],
                'description' => $def['description'],
                'salary_range' => $def['salary_range'],
                'status' => 'open',
                'deadline' => '2026-05-30',
                'published_at' => $now,
            ]);

            $job->seoMeta()->create([
                'seo_enabled' => true,
                'is_indexable' => true,
                'include_in_sitemap' => true,
                'slug' => $def['slug'],
                'canonical_url' => 'https://www.hildes.io/careers/'.$def['slug'],
                'meta_title' => $def['meta_title'],
                'meta_description' => $def['meta_description'],
                'meta_keywords' => $def['focus_keyword'].', HilDes, internship',
                'meta_author' => 'HilDes',
                'meta_viewport' => 'width=device-width, initial-scale=1.0',
                'focus_keyword' => $def['focus_keyword'],
                'robots_directive' => 'index, follow',
                'og_type' => 'website',
                'og_title' => $def['meta_title'],
                'og_description' => $def['meta_description'],
                'og_url' => 'https://www.hildes.io/careers/'.$def['slug'],
                'og_site_name' => 'HilDes',
                'og_image' => 'https://www.hildes.io/og-image.jpg',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => $def['meta_title'],
                'twitter_description' => $def['meta_description'],
                'twitter_image' => 'https://www.hildes.io/og-image.jpg',
                'schema_json' => null,
            ]);
        }
    }

    public function down(): void
    {
        $slugs = ['bdm-intern-may-2026', 'digital-marketing-intern-may-2026'];

        $ids = Job::query()->whereIn('slug', $slugs)->pluck('id');

        foreach ($ids as $id) {
            \Illuminate\Support\Facades\DB::table('seo_metas')
                ->where('seoable_type', Job::class)
                ->where('seoable_id', $id)
                ->delete();
        }

        Job::query()->whereIn('slug', $slugs)->delete();
    }
};
