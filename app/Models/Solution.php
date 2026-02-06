<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model {
    protected $fillable = ['type_solution'];
    public function interventions(){ return $this->hasMany(Intervention::class); }
}

