<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technicien extends Model {
    protected $fillable = ['user_id','nom','prenom','contact'];

    public function user(){ return $this->belongsTo(User::class); }
    public function interventions(){ return $this->hasMany(Intervention::class); }
}
