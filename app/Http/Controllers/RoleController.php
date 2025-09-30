<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Perk;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Role::with(['characters', 'perksIncluded']);

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $roles = $query->paginate(15);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perks = Perk::all();
        return view('roles.create', compact('perks'));
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
            'perks_included' => 'nullable|array',
            'perks_included.*' => 'exists:perks,id',
        ]);

        $role = Role::create($validated);

        if (isset($validated['perks_included'])) {
            $role->perksIncluded()->attach($validated['perks_included']);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load(['characters.user', 'perksIncluded']);
        
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $role->load(['perksIncluded']);
        $perks = Perk::all();

        return view('roles.edit', compact('role', 'perks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'symbol_svg' => 'nullable|string',
            'perks_included' => 'nullable|array',
            'perks_included.*' => 'exists:perks,id',
        ]);

        $role->update($validated);

        // Update relationships
        $role->perksIncluded()->sync($validated['perks_included'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}