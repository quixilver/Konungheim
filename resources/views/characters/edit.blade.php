@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Edit {{ $character->name }}</h1>
            <a href="{{ route('characters.show', $character) }}" class="btn btn-outline-secondary">Back to Character</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('characters.update', $character) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $character->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $character->title) }}" placeholder="e.g., The Viking Warrior">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="picture" class="form-label">Character Picture</label>
                        @if($character->picture)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $character->picture) }}" class="character-picture" alt="{{ $character->name }}">
                                <small class="text-muted d-block">Current picture</small>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('picture') is-invalid @enderror" 
                               id="picture" name="picture" accept="image/*">
                        <small class="text-muted">Leave empty to keep current picture</small>
                        @error('picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="world_current" class="form-label">Current World</label>
                        <select class="form-select @error('world_current') is-invalid @enderror" 
                                id="world_current" name="world_current">
                            <option value="">No world selected</option>
                            @foreach($worlds as $world)
                                <option value="{{ $world->id }}" {{ old('world_current', $character->world_current) == $world->id ? 'selected' : '' }}>
                                    {{ $world->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('world_current')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="weapons" class="form-label">Weapons</label>
                        <div id="weapons-container">
                            @if($character->weapons && count($character->weapons) > 0)
                                @foreach($character->weapons as $weapon)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="weapons[]" value="{{ $weapon }}">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeWeapon(this)">-</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="weapons[]" placeholder="Enter weapon name">
                                    <button type="button" class="btn btn-outline-secondary" onclick="addWeapon()">+</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addWeapon()">Add Weapon</button>
                        <small class="text-muted d-block">Add the weapons your character uses</small>
                    </div>

                    <div class="mb-3">
                        <label for="roles" class="form-label">Roles</label>
                        <div class="row">
                            @foreach($roles as $role)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                               {{ in_array($role->id, old('roles', $character->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="perks" class="form-label">Perks</label>
                        <div class="row">
                            @foreach($perks as $perk)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="perks[]" value="{{ $perk->id }}" id="perk_{{ $perk->id }}"
                                               {{ in_array($perk->id, old('perks', $character->perks->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perk_{{ $perk->id }}">
                                            {{ $perk->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="objective" class="form-label">Objective</label>
                        <textarea class="form-control @error('objective') is-invalid @enderror" 
                                  id="objective" name="objective" rows="4" 
                                  placeholder="Describe your character's current objective or goal...">{{ old('objective', $character->objective) }}</textarea>
                        @error('objective')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('characters.show', $character) }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Character</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function addWeapon() {
    const container = document.getElementById('weapons-container');
    const newWeapon = document.createElement('div');
    newWeapon.className = 'input-group mb-2';
    newWeapon.innerHTML = `
        <input type="text" class="form-control" name="weapons[]" placeholder="Enter weapon name">
        <button type="button" class="btn btn-outline-danger" onclick="removeWeapon(this)">-</button>
    `;
    container.appendChild(newWeapon);
}

function removeWeapon(button) {
    button.parentElement.remove();
}
</script>
@endsection