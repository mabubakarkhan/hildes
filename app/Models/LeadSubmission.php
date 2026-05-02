<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadSubmission extends Model
{
    protected $fillable = [
        'source',
        'full_name',
        'company_name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
    ];
}

