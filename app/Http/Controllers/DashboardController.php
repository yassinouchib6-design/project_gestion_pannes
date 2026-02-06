<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Panne;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role ?? 'utilisateur';

        $stats = [
            'pannes'    => 0,
            'nouvelles' => 0,
            'en_cours'  => 0,
            'resolues'  => 0,
        ];

        $latestPannes = collect();

        // 👤 UTILISATEUR: غير ديالو
        if ($role === 'utilisateur') {

            $stats['pannes'] = Panne::where('utilisateur_id', $user->id)->count();
            $stats['nouvelles'] = Panne::where('utilisateur_id', $user->id)->where('statut', 'nouvelle')->count();
            $stats['en_cours']  = Panne::where('utilisateur_id', $user->id)->where('statut', 'en_cours')->count();
            $stats['resolues']  = Panne::where('utilisateur_id', $user->id)->where('statut', 'resolue')->count();

            $latestPannes = Panne::with('equipement')
                ->where('utilisateur_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        } else {
            // 🛠️ ADMIN / TECHNICIEN
            $stats['pannes'] = Panne::count();
            $stats['nouvelles'] = Panne::where('statut', 'nouvelle')->count();
            $stats['en_cours']  = Panne::where('statut', 'en_cours')->count();
            $stats['resolues']  = Panne::where('statut', 'resolue')->count();

            $latestPannes = Panne::with('equipement')
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact('user', 'role', 'stats', 'latestPannes'));
    }
}