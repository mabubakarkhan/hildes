<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'description',
        'name',
        'company',
        'designation',
        'image',
        'image_original_name',
        'image_alt',
        'display_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'display_order' => 'integer',
        ];
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('id');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! filled($this->image)) {
            return null;
        }

        return rtrim(url('/'), '/').'/storage/'.ltrim($this->image, '/');
    }

    public function displaySubtitle(): string
    {
        $parts = array_filter([
            $this->designation,
            $this->company,
        ]);

        return implode(' at ', array_slice($parts, 0, 2));
    }
}
