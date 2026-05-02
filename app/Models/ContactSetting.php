<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'phone',
        'whatsapp',
        'email',
        'facebook',
        'linkedin',
        'github',
        'header_logo',
        'footer_logo',
        'address_line',
        'google_map_embed',
        'google_map_url',
        'extra_notes',
    ];

    public function mailtoHref(): string
    {
        return filled($this->email) ? 'mailto:'.$this->email : '#';
    }

    public function telHref(): string
    {
        if (! filled($this->phone)) {
            return '#';
        }

        return 'tel:'.preg_replace('/[^\d\+]/', '', (string) $this->phone);
    }

    public function whatsappHref(): string
    {
        if (! filled($this->whatsapp)) {
            return '#';
        }

        $digits = preg_replace('/\D+/', '', (string) $this->whatsapp);

        return $digits !== '' ? 'https://wa.me/'.$digits : '#';
    }
}
