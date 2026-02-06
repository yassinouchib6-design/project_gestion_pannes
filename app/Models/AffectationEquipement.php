<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffectationEquipement extends Model {
    protected $table = 'affectation_equipements';
    protected $fillable = ['equipement_id','utilisateur_id','date_affectation','date_fin'];

    public function equipement(){ return $this->belongsTo(Equipement::class); }
    public function utilisateur(){ return $this->belongsTo(Utilisateur::class); }
}

