<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Panne;
use Illuminate\Http\Request;

class PanneController extends Controller
{
    public function index(Request $r){
        $q = Panne::with(['equipement','utilisateur'])
            ->orderBy('created_at','desc');

        if($r->statut) $q->where('statut',$r->statut);
        if($r->priorite) $q->where('priorite',$r->priorite);
        if($r->equipement_id) $q->where('equipement_id',$r->equipement_id);
        if($r->utilisateur_id) $q->where('utilisateur_id',$r->utilisateur_id);

        if($r->search){
            $s = $r->search;
            $q->where('titre','like',"%$s%")
              ->orWhere('description','like',"%$s%");
        }

        return $q->paginate(10);
    }

    public function store(Request $r){
        $data = $r->validate([
            'equipement_id'=>'required|exists:equipements,id',
            'utilisateur_id'=>'required|exists:utilisateurs,id',
            'titre'=>'required|string|max:255',
            'description'=>'nullable|string',
            'date_panne'=>'nullable|date',
            'contact'=>'nullable|string',
            'priorite'=>'required|in:low,medium,high',
            'type_panne'=>'nullable|string',
        ]);

        $data['statut'] = 'nouvelle';
        return Panne::create($data);
    }

    public function show(Panne $panne){
        return $panne->load(['equipement','utilisateur','interventions.technicien','interventions.solution']);
    }

    public function update(Request $r, Panne $panne){
        $data = $r->validate([
            'titre'=>'sometimes|required|string|max:255',
            'description'=>'nullable|string',
            'date_panne'=>'nullable|date',
            'contact'=>'nullable|string',
            'priorite'=>'sometimes|required|in:low,medium,high',
            'type_panne'=>'nullable|string',
            'statut'=>'sometimes|required|in:nouvelle,en_cours,resolue',
        ]);
        $panne->update($data);
        return $panne;
    }

    public function destroy(Panne $panne){
        $panne->delete();
        return response()->json(['message'=>'deleted']);
    }
}

