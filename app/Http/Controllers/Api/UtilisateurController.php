<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    public function index()
    {
        $utilisateurs = Utilisateur::query()
            ->latest()
            ->paginate(10);

        return response()->json($utilisateurs);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_utilisateur' => ['required','string','max:255'],
            'prenom_utilisateur' => ['required','string','max:255'],
            'num_bureau' => ['nullable','string','max:50'],
            'contact_utilis' => ['nullable','string','max:50'],
            'email_utilisateur' => ['nullable','email','max:255'],
            'structure_id' => ['required','exists:structures,id'],
        ]);

        $utilisateur = Utilisateur::create($data);

        return response()->json([
            'message' => 'Utilisateur créé',
            'data' => $utilisateur
        ], 201);
    }

    public function show(Utilisateur $utilisateur)
    {
        return response()->json($utilisateur);
    }

    public function update(Request $request, Utilisateur $utilisateur)
    {
        $data = $request->validate([
            'nom_utilisateur' => ['sometimes','required','string','max:255'],
            'prenom_utilisateur' => ['sometimes','required','string','max:255'],
            'num_bureau' => ['sometimes','nullable','string','max:50'],
            'contact_utilis' => ['sometimes','nullable','string','max:50'],
            'email_utilisateur' => ['sometimes','nullable','email','max:255'],
            'structure_id' => ['sometimes','required','exists:structures,id'],
        ]);

        $utilisateur->update($data);

        return response()->json([
            'message' => 'Utilisateur modifié',
            'data' => $utilisateur
        ]);
    }

    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();

        return response()->json(['message' => 'Utilisateur supprimé']);
    }
}
