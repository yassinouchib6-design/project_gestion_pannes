<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model {
    protected $fillable = ['structure_id','user_id','nom','prenom','num_bureau','contact','email'];

    public function structure(){ return $this->belongsTo(Structure::class); }
    public function user(){ return $this->belongsTo(User::class); }
    public function pannes(){ return $this->hasMany(Panne::class); }
}

