<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = []; // Allows mass assignment
    protected $fillable = [
        "name",
        "industry",
        "website",
        "logo_url",
        "address", // <-- Add this new line
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}
