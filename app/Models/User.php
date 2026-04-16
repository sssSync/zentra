<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = ["name", "email", "password", "role"];

    protected $hidden = ["password", "remember_token"];

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, "owner_id");
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function initials()
    {
        $names = explode(" ", $this->name);
        $initials = "";

        foreach ($names as $name) {
            $initials .= substr($name, 0, 1);
        }

        return strtoupper(substr($initials, 0, 2));
    }
}
