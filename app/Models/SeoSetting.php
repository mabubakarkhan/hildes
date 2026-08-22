<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SeoSetting extends Model
{
    private const LEGACY_PLACEHOLDER_PATTERNS = [
        '#og-image\.jpg$#i',
        '#assets/og/[^/]+\.jpg$#i',
    ];
    protected $fillable = [
        'default_meta_title',
        'default_meta_description',
        'default_meta_keywords',
        'default_meta_author',
        'default_robots_directive',
        'og_site_name',
        'default_og_type',
        'default_og_image',
        'default_twitter_image',
        'twitter_card',
    ];

    public static function getSingleton(): self
    {
        return Cache::remember('seo_settings.singleton', 300, function (): self {
            return static::query()->first()
                ?? static::query()->create([
                    'default_meta_title' => 'HilDes - Technology Services',
                    'default_meta_description' => 'HilDes is a technology services company specializing in web, mobile, AI, digital marketing, SEO, and graphics.',
                    'default_meta_keywords' => 'HilDes, web development, mobile app development, AI services, digital marketing, SEO, graphics',
                    'default_meta_author' => 'HilDes',
                    'default_robots_directive' => 'index,follow',
                    'og_site_name' => 'HilDes',
                    'default_og_type' => 'website',
                    'twitter_card' => 'summary_large_image',
                ]);
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('seo_settings.singleton');
    }

    public function defaultOgImageUrl(): ?string
    {
        return $this->imageUrl($this->default_og_image);
    }

    public function defaultTwitterImageUrl(): ?string
    {
        return $this->imageUrl($this->default_twitter_image);
    }

    public static function resolveShareImageUrl(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim($value);

        if (self::isLegacyPlaceholder($value)) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return Storage::disk('public')->url($value);
    }

    public static function isLegacyPlaceholder(string $value): bool
    {
        foreach (self::LEGACY_PLACEHOLDER_PATTERNS as $pattern) {
            if (preg_match($pattern, $value)) {
                return true;
            }
        }

        return false;
    }

    public static function publishPublicFile(string $relativePath): void
    {
        $source = storage_path('app/public/'.$relativePath);
        if (! is_file($source)) {
            return;
        }

        $target = public_path('storage/'.$relativePath);
        $directory = dirname($target);
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        copy($source, $target);
    }

    public static function unpublishPublicFile(?string $relativePath): void
    {
        if (blank($relativePath)) {
            return;
        }

        $target = public_path('storage/'.$relativePath);
        if (is_file($target)) {
            unlink($target);
        }
    }

    private function imageUrl(?string $path): ?string
    {
        return self::resolveShareImageUrl($path);
    }
}
