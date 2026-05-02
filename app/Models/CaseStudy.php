<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'tagline',
        'short_description',
        'detail_content',
        'sections_json',
        'featured_image',
        'featured_image_alt',
        'featured_image_original_name',
        'is_published',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sections_json' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (CaseStudy $caseStudy): void {
            if (! $caseStudy->display_order) {
                $caseStudy->display_order = ((int) static::query()->max('display_order')) + 1;
            }
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('id');
    }

    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (! filled($this->featured_image)) {
            return null;
        }

        return rtrim(url('/'), '/').'/storage/'.ltrim($this->featured_image, '/');
    }
}

