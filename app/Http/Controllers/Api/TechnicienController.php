<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Technicien;
use Illuminate\Http\Request;

class TechnicienController extends Controller
{
    public function index()
    {
        $techniciens = Technicien::query()
            ->latest()
            ->paginate(10);

        return response()->json($techniciens);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_technicien' => ['required','string','max:255'],
            'contact_technicie' => ['nullable','string','max:50'],
        ]);

        $technicien = Technicien::create($data);

        return response()->json([
            'message' => 'Technicien créé',
            'data' => $technicien
        ], 201);
    }

    public function show(Technicien $technicien)
    {
        return response()->json($technicien);
    }

    public function update(Request $request, Technicien $technicien)
    {
        $data = $request->validate([
            'nom_technicien' => ['sometimes','required','string','max:255'],
            'contact_technicie' => ['sometimes','nullable','string','max:50'],
        ]);

        $technicien->update($data);

        return response()->json([
            'message' => 'Technicien modifié',
            'data' => $technicien
        ]);
    }

    public function destroy(Technicien $technicien)
    {
        $technicien->delete();

        return response()->json(['message' => 'Technicien supprimé']);
    }
}
