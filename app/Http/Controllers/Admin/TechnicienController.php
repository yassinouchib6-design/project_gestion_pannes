<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TechnicienController extends Controller
{
    public function index()
    {
        $techniciens = User::where('role', 'technicien')->get();
        return view('admin.techniciens.index', compact('techniciens'));
    }

    public function create()
    {
        return view('admin.techniciens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'technicien',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.techniciens.index')
            ->with('success', 'Technicien créé avec succès');
    }
}