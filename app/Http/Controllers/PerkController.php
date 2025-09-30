<?php

namespace App\Http\Controllers;

use App\Models\Perk;
use Illuminate\Http\Request;

class PerkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Perk::with(['characters', 'roles']);

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $perks = $query->paginate(15);

        return view('perks.index', compact('perks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('perks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'symbol_svg' => 'nullable|string',
        ]);

        Perk::create($validated);

        return redirect()->route('perks.index')->with('success', 'Perk created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perk $perk)
    {
        $perk->load(['characters.user', 'roles']);
        
        return view('perks.show', compact('perk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perk $perk)
    {
        return view('perks.edit', compact('perk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perk $perk)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'symbol_svg' => 'nullable|string',
        ]);

        $perk->update($validated);

        return redirect()->route('perks.index')->with('success', 'Perk updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perk $perk)
    {
        $perk->delete();

        return redirect()->route('perks.index')->with('success', 'Perk deleted successfully.');
    }
}