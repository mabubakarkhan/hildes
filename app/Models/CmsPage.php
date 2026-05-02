<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CmsPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'detail_content',
        'banner_image',
        'banner_image_alt',
        'banner_image_original_name',
        'faqs_json',
        'faq_groups_json',
        'faq_schema_version',
        'faq_schema_updated_at',
        'is_published',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'faqs_json' => 'array',
            'faq_groups_json' => 'array',
            'is_published' => 'boolean',
            'faq_schema_updated_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $page): void {
            if ((int) $page->display_order > 0) {
                return;
            }

            $maxOrder = (int) DB::table('cms_pages')->max('display_order');
            $page->display_order = $maxOrder + 1;
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

    public function getBannerImageUrlAttribute(): ?string
    {
        if (! filled($this->banner_image)) {
            return null;
        }

        return rtrim(url('/'), '/').'/storage/'.ltrim($this->banner_image, '/');
    }
}
