<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Solution;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function index()
    {
        $solutions = Solution::query()
            ->latest()
            ->paginate(10);

        return response()->json($solutions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type_solution' => ['required','string','max:255'],
        ]);

        $solution = Solution::create($data);

        return response()->json([
            'message' => 'Solution créée',
            'data' => $solution
        ], 201);
    }

    public function show(Solution $solution)
    {
        return response()->json($solution);
    }

    public function update(Request $request, Solution $solution)
    {
        $data = $request->validate([
            'type_solution' => ['sometimes','required','string','max:255'],
        ]);

        $solution->update($data);

        return response()->json([
            'message' => 'Solution modifiée',
            'data' => $solution
        ]);
    }

    public function destroy(Solution $solution)
    {
        $solution->delete();

        return response()->json(['message' => 'Solution supprimée']);
    }
}
