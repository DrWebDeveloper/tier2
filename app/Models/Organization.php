<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'rid',
        'name',
        'sponsorships',
        'sponsorship_logos',
        'sponsorship_names',
        'sponsorship_websites',
        'logo',
        'country',
        'website',
    ];

    protected $casts = [
        'sponsorships' => 'array',
        'sponsorship_logos' => 'array',
        'sponsorship_names' => 'array',
        'sponsorship_websites' => 'array',
    ];

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }

    public function sponsorshipsCount()
    {
        return $this->sponsorships()->count();
    }

    public function sponsorshipsTotal()
    {
        return $this->sponsorships()->sum('amount');
    }
}
