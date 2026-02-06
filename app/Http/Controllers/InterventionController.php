<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Panne;
use App\Models\User;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $role = $user->role ?? 'utilisateur';

    $query = Intervention::with(['panne.equipement', 'technicien'])->latest();

    // technicien يشوف غير interventions ديالو
    if ($role === 'technicien') {
        $query->where('technicien_id', $user->id);
    }

    $interventions = $query->paginate(10);

    return view('interventions.index', compact('interventions'));
}

    public function create(Request $request)
{
    $pannes = Panne::with('equipement')->latest()->get();

    $techniciens = User::where('role', 'technicien')->orderBy('name')->get();

    $selectedPanneId = $request->query('panne_id');

    return view('interventions.create', compact('pannes', 'techniciens', 'selectedPanneId'));
}

    public function store(Request $request)
{
    $user = auth()->user();
    $role = $user->role ?? 'technicien';

    $data = $request->validate([
        'panne_id'          => 'required|exists:pannes,id',
        'date_intervention' => 'nullable|date',
        'description'       => 'nullable|string',
        'statut_apres'      => 'nullable|in:nouvelle,en_cours,resolue',

        // غير admin اللي يقدر يختار technicien
        'technicien_id'     => ($role === 'admin')
            ? 'nullable|exists:users,id'
            : 'nullable',
    ]);

    // ✅ technicien: كتولي intervention ديالو هو أوتوماتيكيا
    if ($role !== 'admin') {
        $data['technicien_id'] = $user->id;
    } else {
        // admin إلا ماختارش technicien، خليه هو
        $data['technicien_id'] = $data['technicien_id'] ?? $user->id;
    }

    $intervention = Intervention::create($data);

    if (!empty($data['statut_apres'])) {
        Panne::where('id', $data['panne_id'])->update(['statut' => $data['statut_apres']]);
    }

    return redirect()->route('interventions.index')->with('success', 'Intervention ajoutée avec succès.');
}

    public function show(Intervention $intervention)
    {
        $intervention->load(['panne.equipement', 'technicien']);
        return view('interventions.show', compact('intervention'));
    }

    public function edit(Intervention $intervention)
    {
        $pannes = Panne::with('equipement')->latest()->get();
        $techniciens = User::where('role', 'technicien')->orderBy('name')->get();

        return view('interventions.edit', compact('intervention', 'pannes', 'techniciens'));
    }

    public function update(Request $request, Intervention $intervention)
    {
        $user = auth()->user();
        $role = $user->role ?? 'technicien';

        $data = $request->validate([
            'panne_id'          => 'required|exists:pannes,id',
            'date_intervention' => 'nullable|date',
            'description'       => 'nullable|string',
            'statut_apres'      => 'nullable|in:nouvelle,en_cours,resolue',

            'technicien_id'     => ($role === 'admin')
                ? 'nullable|exists:users,id'
                : 'nullable',
        ]);

        if ($role !== 'admin') {
            $data['technicien_id'] = $intervention->technicien_id ?? $user->id; // ما نخليش يبدلها
        } else {
            $data['technicien_id'] = $data['technicien_id'] ?? $intervention->technicien_id;
        }

        $intervention->update($data);

        if (!empty($data['statut_apres'])) {
            $intervention->panne->update(['statut' => $data['statut_apres']]);
        }

        return redirect()->route('interventions.show', $intervention->id)->with('success', 'Intervention modifiée avec succès.');
    }

    public function destroy(Intervention $intervention)
    {
        $intervention->delete();
        return redirect()->route('interventions.index')->with('success', 'Intervention supprimée avec succès.');
    }
}