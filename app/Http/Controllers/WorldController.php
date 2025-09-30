<?php

namespace App\Http\Controllers;

use App\Models\World;
use Illuminate\Http\Request;

class WorldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = World::with(['characters']);

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter by seed
        if ($request->filled('seed')) {
            $query->where('seed', 'like', '%' . $request->seed . '%');
        }

        $worlds = $query->paginate(15);

        return view('worlds.index', compact('worlds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('worlds.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'seed' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'traits' => 'nullable|array',
        ]);

        World::create($validated);

        return redirect()->route('worlds.index')->with('success', 'World created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(World $world)
    {
        $world->load(['characters.user']);
        
        return view('worlds.show', compact('world'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(World $world)
    {
        return view('worlds.edit', compact('world'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, World $world)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'seed' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'traits' => 'nullable|array',
        ]);

        $world->update($validated);

        return redirect()->route('worlds.index')->with('success', 'World updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(World $world)
    {
        $world->delete();

        return redirect()->route('worlds.index')->with('success', 'World deleted successfully.');
    }
}