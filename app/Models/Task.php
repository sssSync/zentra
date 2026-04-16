<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    protected $fillable = [
        "contact_id",
        "user_id",
        "interaction_id",
        "title",
        "due_date",
        "status",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function interaction()
    {
        return $this->belongsTo(Interaction::class);
    }
}
