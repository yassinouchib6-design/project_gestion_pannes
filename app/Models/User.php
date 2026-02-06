<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Panne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // إذا عندك role ف users table خليها
    // protected $fillable = [...];

    public function pannes()
    {
        // FK ف جدول pannes هو utilisateur_id
        return $this->hasMany(Panne::class, 'utilisateur_id');
    }
}