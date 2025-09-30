@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h2 mb-4">Dashboard</h1>
        
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">🗡️ Characters</h5>
                        <p class="card-text display-4">{{ Auth::user()->characters->count() }}</p>
                        <a href="{{ route('characters.index') }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">👥 Roles</h5>
                        <p class="card-text display-4">{{ App\Models\Role::count() }}</p>
                        <a href="{{ route('roles.index') }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">⭐ Perks</h5>
                        <p class="card-text display-4">{{ App\Models\Perk::count() }}</p>
                        <a href="{{ route('perks.index') }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">🌍 Worlds</h5>
                        <p class="card-text display-4">{{ App\Models\World::count() }}</p>
                        <a href="{{ route('worlds.index') }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Characters</h5>
                    </div>
                    <div class="card-body">
                        @if(Auth::user()->characters->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Current World</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Auth::user()->characters->take(5) as $character)
                                            <tr>
                                                <td>
                                                    @if($character->picture)
                                                        <img src="{{ asset('storage/' . $character->picture) }}" class="character-picture me-2" alt="{{ $character->name }}">
                                                    @endif
                                                    {{ $character->name }}
                                                </td>
                                                <td>{{ $character->title ?? '-' }}</td>
                                                <td>{{ $character->world->name ?? '-' }}</td>
                                                <td>{{ $character->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('characters.show', $character) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No characters created yet. <a href="{{ route('characters.create') }}">Create your first character</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection