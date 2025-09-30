@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">🌍 Worlds</h1>
            <a href="{{ route('worlds.create') }}" class="btn btn-primary">Create New World</a>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('worlds.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}" placeholder="Search by name...">
                    </div>
                    <div class="col-md-4">
                        <label for="seed" class="form-label">Seed</label>
                        <input type="text" class="form-control" id="seed" name="seed" value="{{ request('seed') }}" placeholder="Search by seed...">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">Filter</button>
                        <a href="{{ route('worlds.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Worlds List -->
        <div class="row">
            @if($worlds->count() > 0)
                @foreach($worlds as $world)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-2">{{ $world->name }}</h5>
                                
                                @if($world->seed)
                                    <p class="text-muted mb-2">
                                        <small><strong>Seed:</strong> <code>{{ $world->seed }}</code></small>
                                    </p>
                                @endif
                                
                                @if($world->description)
                                    <p class="card-text text-muted">{{ Str::limit($world->description, 100) }}</p>
                                @endif
                                
                                <div class="mb-3">
                                    <small class="text-muted">Characters in this world:</small>
                                    <span class="badge bg-primary">{{ $world->characters->count() }}</span>
                                </div>
                                
                                @if($world->traits && count($world->traits) > 0)
                                    <div class="mb-3">
                                        <small class="text-muted">Traits:</small><br>
                                        @foreach(array_slice($world->traits, 0, 3) as $trait)
                                            <span class="badge bg-secondary me-1">{{ $trait }}</span>
                                        @endforeach
                                        @if(count($world->traits) > 3)
                                            <span class="text-muted">and {{ count($world->traits) - 3 }} more</span>
                                        @endif
                                    </div>
                                @endif
                                
                                <div class="text-muted">
                                    <small>Created: {{ $world->created_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ route('worlds.show', $world) }}" class="btn btn-outline-primary">View</a>
                                    <a href="{{ route('worlds.edit', $world) }}" class="btn btn-outline-secondary">Edit</a>
                                    <form action="{{ route('worlds.destroy', $world) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this world?')">
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
                        <h4 class="text-muted">No worlds found</h4>
                        <p class="text-muted">Create your first world to get started!</p>
                        <a href="{{ route('worlds.create') }}" class="btn btn-primary">Create World</a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($worlds->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $worlds->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection