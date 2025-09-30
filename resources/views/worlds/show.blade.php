@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">{{ $world->name }}</h1>
            <div>
                <a href="{{ route('worlds.edit', $world) }}" class="btn btn-outline-primary me-2">Edit</a>
                <a href="{{ route('worlds.index') }}" class="btn btn-outline-secondary">Back to Worlds</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-4">🌍 {{ $world->name }}</h3>
                        
                        @if($world->seed)
                            <div class="mb-3">
                                <small class="text-muted">World Seed:</small><br>
                                <code class="bg-light p-2 rounded d-block">{{ $world->seed }}</code>
                            </div>
                        @endif
                        
                        @if($world->description)
                            <div class="mb-3">
                                <small class="text-muted">Description:</small><br>
                                <p>{{ $world->description }}</p>
                            </div>
                        @endif
                        
                        <div class="text-center">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h4 class="text-primary">{{ $world->characters->count() }}</h4>
                                    <small class="text-muted">Characters in this world</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-center text-muted">
                            <small>Created: {{ $world->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>

                @if($world->traits && count($world->traits) > 0)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">🌟 World Traits</h5>
                        </div>
                        <div class="card-body">
                            @foreach($world->traits as $trait)
                                <span class="badge bg-secondary me-1 mb-1">{{ $trait }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-8">
                <!-- Characters in this World -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">🗡️ Characters in this World</h5>
                    </div>
                    <div class="card-body">
                        @if($world->characters->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Character</th>
                                            <th>Owner</th>
                                            <th>Roles</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($world->characters as $character)
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
                                                            @if($character->title)
                                                                <br><small class="text-muted">{{ $character->title }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $character->user->name }}</td>
                                                <td>
                                                    @if($character->roles->count() > 0)
                                                        @foreach($character->roles->take(2) as $role)
                                                            <span class="badge bg-secondary me-1">{{ $role->name }}</span>
                                                        @endforeach
                                                        @if($character->roles->count() > 2)
                                                            <span class="text-muted">+{{ $character->roles->count() - 2 }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">No roles</span>
                                                    @endif
                                                </td>
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
                            <p class="text-muted mb-0">No characters are currently in this world.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection