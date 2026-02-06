<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    public function index()
    {
        $interventions = Intervention::query()
            ->with(['panne','technicien','solution'])
            ->latest()
            ->paginate(10);

        return response()->json($interventions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'panne_id' => ['required','exists:pannes,id'],
            'technicien_id' => ['nullable','exists:techniciens,id'],
            'solution_id' => ['nullable','exists:solutions,id'],
            'date_debut' => ['required','date'],
            'date_fin' => ['nullable','date','after_or_equal:date_debut'],
            'rapport_intervention' => ['nullable','string'],
        ]);

        $intervention = Intervention::create($data);

        return response()->json([
            'message' => 'Intervention créée',
            'data' => $intervention
        ], 201);
    }

    public function show(Intervention $intervention)
    {
        $intervention->load(['panne','technicien','solution']);
        return response()->json($intervention);
    }

    public function update(Request $request, Intervention $intervention)
    {
        $data = $request->validate([
            'panne_id' => ['sometimes','required','exists:pannes,id'],
            'technicien_id' => ['sometimes','nullable','exists:techniciens,id'],
            'solution_id' => ['sometimes','nullable','exists:solutions,id'],
            'date_debut' => ['sometimes','required','date'],
            'date_fin' => ['sometimes','nullable','date','after_or_equal:date_debut'],
            'rapport_intervention' => ['sometimes','nullable','string'],
        ]);

        $intervention->update($data);

        return response()->json([
            'message' => 'Intervention modifiée',
            'data' => $intervention
        ]);
    }

    public function destroy(Intervention $intervention)
    {
        $intervention->delete();

        return response()->json(['message' => 'Intervention supprimée']);
    }
}
