<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    public function index(Request $r){
        $q = Equipement::query()->orderBy('id','desc');

        if($r->search){
            $s = $r->search;
            $q->where('serie_equipement','like',"%$s%")
              ->orWhere('type_equipement','like',"%$s%")
              ->orWhere('marque_equipement','like',"%$s%")
              ->orWhere('modele_equipement','like',"%$s%");
        }
        return $q->paginate(10);
    }

    public function store(Request $r){
        $data = $r->validate([
            'serie_equipement'=>'required|string|unique:equipements,serie_equipement',
            'type_equipement'=>'required|string',
            'marque_equipement'=>'nullable|string',
            'modele_equipement'=>'nullable|string',
            'date_acquisition'=>'nullable|date',
        ]);
        return Equipement::create($data);
    }

    public function show(Equipement $equipement){ return $equipement; }

    public function update(Request $r, Equipement $equipement){
        $data = $r->validate([
            'serie_equipement'=>'required|string|unique:equipements,serie_equipement,'.$equipement->id,
            'type_equipement'=>'required|string',
            'marque_equipement'=>'nullable|string',
            'modele_equipement'=>'nullable|string',
            'date_acquisition'=>'nullable|date',
        ]);
        $equipement->update($data);
        return $equipement;
    }

    public function destroy(Equipement $equipement){
        $equipement->delete();
        return response()->json(['message'=>'deleted']);
    }
}
