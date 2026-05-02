<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $fillable = [
        'seo_enabled',
        'is_indexable',
        'include_in_sitemap',
        'slug',
        'canonical_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_author',
        'meta_viewport',
        'focus_keyword',
        'robots_directive',
        'og_type',
        'og_title',
        'og_description',
        'og_url',
        'og_site_name',
        'og_image',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'schema_json',
    ];

    protected function casts(): array
    {
        return [
            'seo_enabled' => 'boolean',
            'is_indexable' => 'boolean',
            'include_in_sitemap' => 'boolean',
        ];
    }

    public function seoable()
    {
        return $this->morphTo();
    }
}
