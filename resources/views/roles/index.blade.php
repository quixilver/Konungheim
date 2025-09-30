@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">👥 Roles</h1>
            <a href="{{ route('roles.create') }}" class="btn btn-primary">Create New Role</a>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('roles.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}" placeholder="Search by name...">
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">Filter</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Roles List -->
        <div class="row">
            @if($roles->count() > 0)
                @foreach($roles as $role)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    @if($role->symbol_svg)
                                        <div class="symbol-svg me-3">{!! $role->symbol_svg !!}</div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1">{{ $role->name }}</h5>
                                        @if($role->description)
                                            <p class="card-text text-muted">{{ Str::limit($role->description, 100) }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted">Characters with this role:</small>
                                    <span class="badge bg-primary">{{ $role->characters->count() }}</span>
                                </div>
                                
                                @if($role->perksIncluded->count() > 0)
                                    <div class="mb-3">
                                        <small class="text-muted">Included Perks:</small><br>
                                        @foreach($role->perksIncluded->take(3) as $perk)
                                            <span class="badge bg-secondary me-1">{{ $perk->name }}</span>
                                        @endforeach
                                        @if($role->perksIncluded->count() > 3)
                                            <span class="text-muted">and {{ $role->perksIncluded->count() - 3 }} more</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ route('roles.show', $role) }}" class="btn btn-outline-primary">View</a>
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-outline-secondary">Edit</a>
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this role?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center py-5">
                        <h4 class="text-muted">No roles found</h4>
                        <p class="text-muted">Create your first role to get started!</p>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">Create Role</a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($roles->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $roles->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection