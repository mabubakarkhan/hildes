<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'website_url',
        'notes',
        'logo',
        'logo_original_name',
        'background_color',
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

    public function getLogoUrlAttribute(): ?string
    {
        if (! filled($this->logo)) {
            return null;
        }

        return rtrim(url('/'), '/').'/storage/'.ltrim($this->logo, '/');
    }
}
