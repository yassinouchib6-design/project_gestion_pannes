<?php

namespace App\Http\Controllers;

use App\Models\Panne;
use App\Models\Equipement;
use Illuminate\Http\Request;

class PanneController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role ?? 'utilisateur';

        $query = Panne::with('equipement')->latest();

        if ($role === 'utilisateur') {
            $query->where('utilisateur_id', $user->id);
        }

        $pannes = $query->paginate(10);

        return view('pannes.index', compact('pannes'));
    }

    public function create()
    {
        $equipements = Equipement::orderBy('id', 'desc')->get();
        return view('pannes.create', compact('equipements'));
    }

    public function store(Request $request)
    {
        $user = auth()->user(); // ✅ بلا Auth

        $data = $request->validate([
            'equipement_id' => 'required|integer|exists:equipements,id',
            'titre'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'date_panne'    => 'nullable|date',
            'contact'       => 'nullable|string|max:255',
            'priorite'      => 'required|in:low,medium,high',
            'type_panne'    => 'nullable|string|max:100',
        ]);

        $data['utilisateur_id'] = $user->id;
        $data['statut'] = 'nouvelle';

        Panne::create($data);

        return redirect()->route('pannes.index')->with('success', 'Panne ajoutée avec succès.');
    }

    public function show(Panne $panne)
    {
        $this->authorizePanne($panne);

        $panne->load([
            'equipement',
            'utilisateur',
            'interventions'
        ]);

        return view('pannes.show', compact('panne'));
    }

    public function edit(Panne $panne)
    {
        $this->authorizePanne($panne);

        $equipements = Equipement::all();
        return view('pannes.edit', compact('panne', 'equipements'));
    }

    public function update(Request $request, Panne $panne)
    {
        $this->authorizePanne($panne);

        $user = auth()->user();
        $role = $user->role ?? 'utilisateur';

        $data = $request->validate([
            'equipement_id' => 'required|exists:equipements,id',
            'titre'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'date_panne'    => 'nullable|date',
            'contact'       => 'nullable|string|max:255',
            'priorite'      => 'required|in:low,medium,high',
            'type_panne'    => 'nullable|string|max:255',
            'statut'        => ($role === 'utilisateur') ? 'nullable' : 'nullable|in:nouvelle,en_cours,resolue',
        ]);

        if ($role === 'utilisateur') {
            unset($data['statut']);
        }

        $panne->update($data);

        return redirect()->route('dashboard')->with('success', 'Panne modifiée avec succès');
    }

    public function destroy(Panne $panne)
    {
        $this->authorizePanne($panne);

        $panne->delete();

        return redirect()->route('pannes.index')->with('success', 'Panne supprimée avec succès');
    }

    private function authorizePanne(Panne $panne): void
    {
        $user = auth()->user();
        $role = $user->role ?? 'utilisateur';

        if ($role === 'utilisateur' && $panne->utilisateur_id !== $user->id) {
            abort(403);
        }
    }
}