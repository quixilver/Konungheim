@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">⭐ Perks</h1>
            <a href="{{ route('perks.create') }}" class="btn btn-primary">Create New Perk</a>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('perks.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}" placeholder="Search by name...">
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">Filter</button>
                        <a href="{{ route('perks.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Perks List -->
        <div class="row">
            @if($perks->count() > 0)
                @foreach($perks as $perk)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start mb-3">
                                    @if($perk->symbol_svg)
                                        <div class="symbol-svg me-3">{!! $perk->symbol_svg !!}</div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1">{{ $perk->name }}</h5>
                                        @if($perk->description)
                                            <p class="card-text text-muted">{{ Str::limit($perk->description, 100) }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted">Characters with this perk:</small>
                                    <span class="badge bg-primary">{{ $perk->characters->count() }}</span>
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted">Included in roles:</small>
                                    <span class="badge bg-success">{{ $perk->roles->count() }}</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ route('perks.show', $perk) }}" class="btn btn-outline-primary">View</a>
                                    <a href="{{ route('perks.edit', $perk) }}" class="btn btn-outline-secondary">Edit</a>
                                    <form action="{{ route('perks.destroy', $perk) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this perk?')">
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
                        <h4 class="text-muted">No perks found</h4>
                        <p class="text-muted">Create your first perk to get started!</p>
                        <a href="{{ route('perks.create') }}" class="btn btn-primary">Create Perk</a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($perks->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $perks->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection