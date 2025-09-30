<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Role;
use App\Models\Perk;
use App\Models\World;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Character::with(['user', 'world', 'roles', 'perks']);

        // Filter by owner (show only user's characters unless admin)
        if (!$request->has('all')) {
            $query->where('user_owner', Auth::id());
        }

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter by world
        if ($request->filled('world_id')) {
            $query->where('world_current', $request->world_id);
        }

        // Filter by role
        if ($request->filled('role_id')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('role_id', $request->role_id);
            });
        }

        $characters = $query->paginate(15);
        $worlds = World::all();
        $roles = Role::all();

        return view('characters.index', compact('characters', 'worlds', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $worlds = World::all();
        $roles = Role::all();
        $perks = Perk::all();

        return view('characters.create', compact('worlds', 'roles', 'perks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weapons' => 'nullable|array',
            'objective' => 'nullable|string',
            'world_current' => 'nullable|exists:worlds,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'perks' => 'nullable|array',
            'perks.*' => 'exists:perks,id',
        ]);

        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('characters', 'public');
        }

        $validated['user_owner'] = Auth::id();

        $character = Character::create($validated);

        if (isset($validated['roles'])) {
            $character->roles()->attach($validated['roles']);
        }

        if (isset($validated['perks'])) {
            $character->perks()->attach($validated['perks']);
        }

        return redirect()->route('characters.index')->with('success', 'Character created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Character $character)
    {
        $character->load(['user', 'world', 'roles', 'perks']);
        
        return view('characters.show', compact('character'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Character $character)
    {
        // Check if user owns the character
        if ($character->user_owner !== Auth::id()) {
            abort(403);
        }

        $character->load(['roles', 'perks']);
        $worlds = World::all();
        $roles = Role::all();
        $perks = Perk::all();

        return view('characters.edit', compact('character', 'worlds', 'roles', 'perks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Character $character)
    {
        // Check if user owns the character
        if ($character->user_owner !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weapons' => 'nullable|array',
            'objective' => 'nullable|string',
            'world_current' => 'nullable|exists:worlds,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'perks' => 'nullable|array',
            'perks.*' => 'exists:perks,id',
        ]);

        if ($request->hasFile('picture')) {
            // Delete old picture if exists
            if ($character->picture) {
                Storage::disk('public')->delete($character->picture);
            }
            $validated['picture'] = $request->file('picture')->store('characters', 'public');
        }

        $character->update($validated);

        // Update relationships
        $character->roles()->sync($validated['roles'] ?? []);
        $character->perks()->sync($validated['perks'] ?? []);

        return redirect()->route('characters.index')->with('success', 'Character updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character)
    {
        // Check if user owns the character
        if ($character->user_owner !== Auth::id()) {
            abort(403);
        }

        // Delete picture if exists
        if ($character->picture) {
            Storage::disk('public')->delete($character->picture);
        }

        $character->delete();

        return redirect()->route('characters.index')->with('success', 'Character deleted successfully.');
    }
}