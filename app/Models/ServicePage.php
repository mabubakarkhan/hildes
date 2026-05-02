<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServicePage extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_published',
        'general_image',
        'general_image_alt',
        'general_image_original_name',
        'display_order',
        'hero_headline',
        'hero_content',
        'hero_image',
        'hero_image_alt',
        'hero_image_original_name',
        'body_heading',
        'body_content',
        'body_image',
        'body_image_alt',
        'body_image_original_name',
        'deliverables_text',
        'process_text',
        'global_focus_text',
        'faq_text',
        'faqs_json',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'faqs_json' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $service): void {
            if ((int) $service->display_order > 0) {
                return;
            }

            $maxOrder = (int) DB::table('service_pages')->max('display_order');
            $service->display_order = $maxOrder + 1;
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('id');
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->publicStorageUrl($this->hero_image);
    }

    public function getGeneralImageUrlAttribute(): ?string
    {
        return $this->publicStorageUrl($this->general_image);
    }

    public function getBodyImageUrlAttribute(): ?string
    {
        return $this->publicStorageUrl($this->body_image);
    }

    private function publicStorageUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        return rtrim(url('/'), '/').'/storage/'.ltrim($path, '/');
    }

    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
