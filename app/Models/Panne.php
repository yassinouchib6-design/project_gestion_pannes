<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panne extends Model
{
    protected $fillable = [
        'equipement_id',
        'utilisateur_id',
        'titre',
        'description',
        'date_panne',
        'contact',
        'priorite',
        'type_panne',
        'statut',
    ];

    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
}