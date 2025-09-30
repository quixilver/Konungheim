@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">🗡️ Characters</h1>
            <a href="{{ route('characters.create') }}" class="btn btn-primary">Create New Character</a>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('characters.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}" placeholder="Search by name...">
                    </div>
                    <div class="col-md-3">
                        <label for="world_id" class="form-label">World</label>
                        <select class="form-select" id="world_id" name="world_id">
                            <option value="">All Worlds</option>
                            @foreach($worlds as $world)
                                <option value="{{ $world->id }}" {{ request('world_id') == $world->id ? 'selected' : '' }}>
                                    {{ $world->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select class="form-select" id="role_id" name="role_id">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">Filter</button>
                        <a href="{{ route('characters.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Characters List -->
        <div class="card">
            <div class="card-body">
                @if($characters->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Character</th>
                                    <th>Title</th>
                                    <th>Owner</th>
                                    <th>Current World</th>
                                    <th>Roles</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($characters as $character)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($character->picture)
                                                    <img src="{{ asset('storage/' . $character->picture) }}" class="character-picture me-3" alt="{{ $character->name }}">
                                                @else
                                                    <div class="character-picture me-3 bg-secondary d-flex align-items-center justify-content-center text-white">
                                                        {{ strtoupper(substr($character->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong>{{ $character->name }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $character->title ?? '-' }}</td>
                                        <td>{{ $character->user->name }}</td>
                                        <td>{{ $character->world->name ?? '-' }}</td>
                                        <td>
                                            @if($character->roles->count() > 0)
                                                @foreach($character->roles as $role)
                                                    <span class="badge bg-secondary me-1">{{ $role->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No roles</span>
                                            @endif
                                        </td>
                                        <td>{{ $character->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('characters.show', $character) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                @if($character->user_owner == Auth::id())
                                                    <a href="{{ route('characters.edit', $character) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                    <form action="{{ route('characters.destroy', $character) }}" method="POST" class="d-inline" 
                                                          onsubmit="return confirm('Are you sure you want to delete this character?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $characters->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <h4 class="text-muted">No characters found</h4>
                        <p class="text-muted">Create your first character to get started!</p>
                        <a href="{{ route('characters.create') }}" class="btn btn-primary">Create Character</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection