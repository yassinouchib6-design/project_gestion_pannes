<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TechnicienController extends Controller
{
    public function index()
    {
        // ✅ كنجيبو techniciens table باش تكون relations صحيحة
        $techniciens = Technicien::with('user')->orderBy('id','desc')->paginate(10);
        return view('techniciens.index', compact('techniciens'));
    }

    public function create()
    {
        return view('techniciens.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // 1) create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'technicien',
            'password' => Hash::make($data['password']),
        ]);

        // 2) ✅ create technicien automatically
        Technicien::create([
            'user_id' => $user->id,
            'nom' => $data['name'],
            'prenom' => null,
            'contact' => null,
        ]);

        return redirect()->route('techniciens.index')->with('success', 'Technicien créé avec succès.');
    }

    public function destroy(Technicien $technicien)
    {
        // حذف user و technicien معاه
        if ($technicien->user) {
            $technicien->user->delete();
        }
        $technicien->delete();

        return redirect()->route('techniciens.index')->with('success', 'Technicien supprimé.');
    }
}