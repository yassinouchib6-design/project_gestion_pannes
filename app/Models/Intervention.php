<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'panne_id',
        'technicien_id',
        'solution_id',
        'date_debut',
        'date_fin',
        'rapport_intervention',
        'statut',
    ];

    public function panne()
    {
        return $this->belongsTo(Panne::class);
    }

    // ✅ هنا خاصها Technicien ماشي User
   public function technicien()
{
    return $this->belongsTo(\App\Models\Technicien::class, 'technicien_id');
}
}