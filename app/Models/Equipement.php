<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipement extends Model {
    protected $fillable = ['serie_equipement','type_equipement','marque_equipement','modele_equipement','date_acquisition'];

    public function pannes(){ return $this->hasMany(Panne::class); }
    public function affectations(){ return $this->hasMany(AffectationEquipement::class); }
}
