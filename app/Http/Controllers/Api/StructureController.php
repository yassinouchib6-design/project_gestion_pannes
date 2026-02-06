<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StructureController extends Controller
{
    public function index()
    {
        // إلا ماعندكش id خدم ب code_structure
        return Structure::orderBy('code_structure', 'asc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code_structure' => ['required','string', Rule::unique('structure', 'code_structure')],
            'nom_structure'  => ['required','string'],
        ]);

        $structure = Structure::create($data);

        return response()->json($structure, 201);
    }

    public function show(Structure $structure)
    {
        return $structure;
    }

    public function update(Request $request, Structure $structure)
    {
        $data = $request->validate([
    'code_structure' => 'required|string|unique:structure,code_structure',
    'nom_structure'  => 'required|string',

]);


        $structure->update($data);

        return $structure;
    }

    public function destroy(Structure $structure)
    {
        $structure->delete();
        return response()->json(['message' => 'deleted']);
    }
}
