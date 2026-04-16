<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        "contact_id",
        "user_id",
        "name",
        "amount",
        "stage",
        "expected_close_date",
    ];
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
