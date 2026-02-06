<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model {
    protected $fillable = [
        'panne_id','technicien_id','solution_id',
        'date_debut','date_fin','rapport_intervention','statut'
    ];

    public function panne(){ return $this->belongsTo(Panne::class); }
    public function technicien(){ return $this->belongsTo(Technicien::class); }
    public function solution(){ return $this->belongsTo(Solution::class); }
}

