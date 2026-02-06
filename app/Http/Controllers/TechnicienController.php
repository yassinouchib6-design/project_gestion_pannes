<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TechnicienController extends Controller
{
    public function index()
    {
        $techniciens = User::where('role', 'technicien')->orderBy('id', 'desc')->paginate(10);
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

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'technicien',
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('techniciens.index')->with('success', 'Technicien créé avec succès.');
    }

    public function destroy(User $user)
    {
        if (($user->role ?? '') !== 'technicien') {
            return redirect()->route('techniciens.index')->with('error', 'Cet utilisateur n\'est pas un technicien.');
        }

        $user->delete();

        return redirect()->route('techniciens.index')->with('success', 'Technicien supprimé.');
    }
}