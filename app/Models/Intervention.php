<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'panne_id',
        'technicien_id',
        'date_intervention',
        'description',
        'statut_apres',
    ];

    public function panne()
    {
        return $this->belongsTo(\App\Models\Panne::class);
    }

    public function technicien()
    {
        return $this->belongsTo(\App\Models\User::class, 'technicien_id');
    }
}