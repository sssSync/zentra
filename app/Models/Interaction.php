<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    protected $guarded = [];
    protected $fillable = [
        "contact_id",
        "user_id",
        "type",
        "content",
        "interaction_date",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
