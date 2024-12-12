<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $fillable = ['rid', 'name', 'sponsors'];

    protected $casts = [
        'sponsors' => 'array',
    ];

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class, 'industry_rid', 'rid');
    }
}
