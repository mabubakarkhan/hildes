<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHeroSetting extends Model
{
    protected $fillable = [
        'aspect_ratio_width',
        'aspect_ratio_height',
    ];

    protected function casts(): array
    {
        return [
            'aspect_ratio_width' => 'integer',
            'aspect_ratio_height' => 'integer',
        ];
    }

    public static function getSingleton(): self
    {
        return static::query()->first()
            ?? static::query()->create([
                'aspect_ratio_width' => 16,
                'aspect_ratio_height' => 9,
            ]);
    }

    public function aspectRatioLabel(): string
    {
        $w = max(1, (int) $this->aspect_ratio_width);
        $h = max(1, (int) $this->aspect_ratio_height);

        return $w.':'.$h;
    }
}
