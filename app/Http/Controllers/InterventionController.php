<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Panne;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterventionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role ?? 'utilisateur';

        $query = Intervention::with(['panne.equipement', 'technicien.user'])->latest();

        // ✅ technicien يشوف غير interventions ديالو
        if ($role === 'technicien') {
            $techId = Technicien::where('user_id', $user->id)->value('id');
            $query->where('technicien_id', $techId);
        }

        $interventions = $query->paginate(10);
        return view('interventions.index', compact('interventions','role'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $role = $user->role ?? 'utilisateur';

        $pannes = Panne::with('equipement')->latest()->get();
        $techniciens = collect();

        if ($role === 'admin') {
            $techniciens = Technicien::with('user')->orderBy('id','desc')->get();
        }

        $selectedPanneId = $request->get('panne_id');
        return view('interventions.create', compact('pannes','techniciens','selectedPanneId','role'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $role = $user->role ?? 'utilisateur';

        $rules = [
            'panne_id' => 'required|exists:pannes,id',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'statut' => 'required|in:planifiee,en_cours,terminee',
            'rapport_intervention' => 'nullable|string',
        ];

        if ($role === 'admin') {
            $rules['technicien_id'] = 'required|exists:techniciens,id';
        }

        $data = $request->validate($rules);

        // ✅ technicien: ناخدو technicien_id من table techniciens
        if ($role !== 'admin') {
            $techId = Technicien::where('user_id', $user->id)->value('id');
            if (!$techId) {
                return back()->withErrors(['technicien_id' => 'Technicien introuvable pour cet utilisateur.'])
                    ->withInput();
            }
            $data['technicien_id'] = $techId;
        }

        Intervention::create($data);

        return redirect()->route('interventions.index')->with('success', 'Intervention ajoutée avec succès.');
    }
}