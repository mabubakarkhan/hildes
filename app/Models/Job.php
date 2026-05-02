<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'career_jobs';

    protected $fillable = [
        'title',
        'icon_class',
        'slug',
        'department',
        'employment_type',
        'location',
        'work_mode',
        'experience_level',
        'min_experience_years',
        'max_experience_years',
        'education_requirements',
        'required_skills',
        'responsibilities',
        'description',
        'salary_range',
        'status',
        'deadline',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'published_at' => 'datetime',
        ];
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
