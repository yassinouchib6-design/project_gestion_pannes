<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AffectationEquipement;
use Illuminate\Http\Request;

class AffectationEquipementController extends Controller
{
    public function index()
    {
        $affectations = AffectationEquipement::query()
            ->with(['equipement','utilisateur'])
            ->latest()
            ->paginate(10);

        return response()->json($affectations);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'equipement_id' => ['required','exists:equipements,id'],
            'utilisateur_id' => ['required','exists:utilisateurs,id'],
            'date_affectation' => ['nullable','date'],
        ]);

        $affectation = AffectationEquipement::create($data);

        return response()->json([
            'message' => 'Affectation créée',
            'data' => $affectation
        ], 201);
    }

    public function show(AffectationEquipement $affectation_equipement)
    {
        $affectation_equipement->load(['equipement','utilisateur']);
        return response()->json($affectation_equipement);
    }

    public function update(Request $request, AffectationEquipement $affectation_equipement)
    {
        $data = $request->validate([
            'equipement_id' => ['sometimes','required','exists:equipements,id'],
            'utilisateur_id' => ['sometimes','required','exists:utilisateurs,id'],
            'date_affectation' => ['sometimes','nullable','date'],
        ]);

        $affectation_equipement->update($data);

        return response()->json([
            'message' => 'Affectation modifiée',
            'data' => $affectation_equipement
        ]);
    }

    public function destroy(AffectationEquipement $affectation_equipement)
    {
        $affectation_equipement->delete();

        return response()->json(['message' => 'Affectation supprimée']);
    }
}
