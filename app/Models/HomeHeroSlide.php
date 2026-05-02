<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHeroSlide extends Model
{
    protected $fillable = [
        'pre_title_span',
        'pre_title_rest',
        'title',
        'disc',
        'button_label',
        'link_type',
        'button_url',
        'linked_service_id',
        'linked_case_study_id',
        'background_image',
        'small_device_background_image',
        'background_image_original_name',
        'style_variant',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'linked_service_id' => 'integer',
            'linked_case_study_id' => 'integer',
        ];
    }

    public function service()
    {
        return $this->belongsTo(ServicePage::class, 'linked_service_id');
    }

    public function caseStudy()
    {
        return $this->belongsTo(CaseStudy::class, 'linked_case_study_id');
    }

    public function getBackgroundImageUrlAttribute(): ?string
    {
        if (! $this->background_image) {
            return null;
        }

        return asset('storage/'.$this->background_image);
    }

    public function getSmallDeviceBackgroundImageUrlAttribute(): ?string
    {
        if (! $this->small_device_background_image) {
            return null;
        }

        return asset('storage/'.$this->small_device_background_image);
    }

    public function hasSmallDeviceBackground(): bool
    {
        return filled($this->small_device_background_image);
    }

    /** Inline CSS for banner background (overrides theme defaults). */
    public function bannerBackgroundStyle(): string
    {
        $url = $this->background_image_url;
        if (! $url) {
            return '';
        }

        return 'background-image: url('.e($url).');';
    }

    public function bannerSmallDeviceBackgroundStyle(): string
    {
        $url = $this->small_device_background_image_url;
        if (! $url) {
            return '';
        }

        return 'background-image: url('.e($url).');';
    }

    /**
     * Same banner element: CSS variables only (no extra layer divs) so Swiper/shape animations stay intact.
     */
    public function bannerDualBackgroundStyle(): string
    {
        if (! $this->hasSmallDeviceBackground() || ! $this->background_image_url) {
            return $this->bannerBackgroundStyle();
        }

        $desktop = $this->background_image_url;
        $mobile = $this->small_device_background_image_url;

        return '--hero-bg-desktop: url('.e($desktop).'); --hero-bg-mobile: url('.e($mobile).');';
    }

    public function variantClasses(): string
    {
        $base = 'rts-banner-area-two rts-section-gap bg_image';
        $v = $this->style_variant;

        return match ($v) {
            'two' => $base.' two',
            'three' => $base.' three',
            default => $base,
        };
    }

    public function resolvedButtonUrl(): ?string
    {
        if ($this->link_type === 'service' && $this->service?->slug) {
            return route('service.slug', ['slug' => $this->service->slug]);
        }

        if ($this->link_type === 'case_study' && $this->caseStudy?->slug) {
            return route('case-studies.show', ['slug' => $this->caseStudy->slug]);
        }

        if ($this->link_type === 'custom') {
            return $this->button_url ?: null;
        }

        return $this->button_url ?: null;
    }
}
