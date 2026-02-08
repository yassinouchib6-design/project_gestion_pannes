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
        $user = auth()->user();
        $role = $user->role ?? 'technicien';

        // admin: يشوف جميع pannes
        // technicien: يشوف غير nouvelle/en_cours (باش يخدم عليهم)
        $pannesQuery = Panne::with('equipement')->latest();

        if ($role === 'technicien') {
            $pannesQuery->whereIn('statut', ['nouvelle', 'en_cours']);
        }

        $pannes = $pannesQuery->get();

        $techniciens = ($role === 'admin')
            ? User::where('role', 'technicien')->orderBy('name')->get()
            : collect();

        $selectedPanneId = $request->query('panne_id');

        return view('interventions.create', compact('pannes', 'techniciens', 'selectedPanneId', 'role'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $role = $user->role ?? 'technicien';

        $rules = [
            'panne_id'          => 'required|exists:pannes,id',
            'date_intervention' => 'nullable|date',
            'description'       => 'nullable|string',
            'statut_apres'      => 'nullable|in:nouvelle,en_cours,resolue',
        ];

        // admin يقدر يختار technicien
        if ($role === 'admin') {
            $rules['technicien_id'] = 'required|exists:users,id';
        }

        $data = $request->validate($rules);

        // technicien: ديما هو اللي كيتسجل
        if ($role !== 'admin') {
            $data['technicien_id'] = $user->id;
        }

        // ✅ create intervention (statut_apres راه column موجود)
        $intervention = Intervention::create($data);

        // ✅ update statut ديال panne إذا اختار
        if (!empty($data['statut_apres'])) {
            Panne::where('id', $data['panne_id'])
                ->update(['statut' => $data['statut_apres']]);
        }

        return redirect()
            ->route('interventions.index')
            ->with('success', 'Intervention ajoutée avec succès.');
    }

    public function show(Intervention $intervention)
    {
        $intervention->load(['panne.equipement', 'technicien']);
        return view('interventions.show', compact('intervention'));
    }

    public function edit(Intervention $intervention)
    {
        $user = auth()->user();
        $role = $user->role ?? 'technicien';

        $pannes = Panne::with('equipement')->latest()->get();
        $techniciens = ($role === 'admin')
            ? User::where('role', 'technicien')->orderBy('name')->get()
            : collect();

        return view('interventions.edit', compact('intervention', 'pannes', 'techniciens', 'role'));
    }

    public function update(Request $request, Intervention $intervention)
    {
        $user = auth()->user();
        $role = $user->role ?? 'technicien';

        $rules = [
            'panne_id'          => 'required|exists:pannes,id',
            'date_intervention' => 'nullable|date',
            'description'       => 'nullable|string',
            'statut_apres'      => 'nullable|in:nouvelle,en_cours,resolue',
        ];

        if ($role === 'admin') {
            $rules['technicien_id'] = 'required|exists:users,id';
        }

        $data = $request->validate($rules);

        if ($role !== 'admin') {
            $data['technicien_id'] = $intervention->technicien_id ?? $user->id; // ما يبدلهاش
        }

        $intervention->update($data);

        if (!empty($data['statut_apres'])) {
            $intervention->panne->update(['statut' => $data['statut_apres']]);
        }

        return redirect()
            ->route('interventions.index')
            ->with('success', 'Intervention modifiée avec succès.');
    }

    public function destroy(Intervention $intervention)
    {
        $intervention->delete();

        return redirect()
            ->route('interventions.index')
            ->with('success', 'Intervention supprimée avec succès.');
    }
}