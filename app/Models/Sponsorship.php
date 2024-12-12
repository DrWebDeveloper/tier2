<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $fillable = [
        'rid',
        'esports_org',
        'industry_rid',
        'name',
        'logo',
        'website',
        'created_at',
    ];

    protected $casts = [
        'logo' => 'array',
    ];
}
