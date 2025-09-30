@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">{{ $character->name }}</h1>
            <div>
                @if($character->user_owner == Auth::id())
                    <a href="{{ route('characters.edit', $character) }}" class="btn btn-outline-primary me-2">Edit</a>
                @endif
                <a href="{{ route('characters.index') }}" class="btn btn-outline-secondary">Back to Characters</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($character->picture)
                            <img src="{{ asset('storage/' . $character->picture) }}" 
                                 class="img-fluid rounded-circle mb-3" 
                                 style="width: 200px; height: 200px; object-fit: cover;" 
                                 alt="{{ $character->name }}">
                        @else
                            <div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white" 
                                 style="width: 200px; height: 200px; font-size: 4rem;">
                                {{ strtoupper(substr($character->name, 0, 1)) }}
                            </div>
                        @endif
                        
                        <h3>{{ $character->name }}</h3>
                        @if($character->title)
                            <p class="text-muted mb-3">{{ $character->title }}</p>
                        @endif
                        
                        <div class="mb-3">
                            <small class="text-muted">Owner:</small><br>
                            <strong>{{ $character->user->name }}</strong>
                        </div>
                        
                        @if($character->world)
                            <div class="mb-3">
                                <small class="text-muted">Current World:</small><br>
                                <a href="{{ route('worlds.show', $character->world) }}" class="text-decoration-none">
                                    <strong>{{ $character->world->name }}</strong>
                                </a>
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <small class="text-muted">Created:</small><br>
                            <strong>{{ $character->created_at->format('M d, Y') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Roles -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">👥 Roles</h5>
                    </div>
                    <div class="card-body">
                        @if($character->roles->count() > 0)
                            <div class="row">
                                @foreach($character->roles as $role)
                                    <div class="col-sm-6 col-lg-4 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center">
                                                    @if($role->symbol_svg)
                                                        <div class="symbol-svg me-2">{!! $role->symbol_svg !!}</div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('roles.show', $role) }}" class="text-decoration-none">
                                                                {{ $role->name }}
                                                            </a>
                                                        </h6>
                                                        @if($role->description)
                                                            <small class="text-muted">{{ Str::limit($role->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">No roles assigned to this character.</p>
                        @endif
                    </div>
                </div>

                <!-- Perks -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">⭐ Perks</h5>
                    </div>
                    <div class="card-body">
                        @if($character->perks->count() > 0)
                            <div class="row">
                                @foreach($character->perks as $perk)
                                    <div class="col-sm-6 col-lg-4 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center">
                                                    @if($perk->symbol_svg)
                                                        <div class="symbol-svg me-2">{!! $perk->symbol_svg !!}</div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('perks.show', $perk) }}" class="text-decoration-none">
                                                                {{ $perk->name }}
                                                            </a>
                                                        </h6>
                                                        @if($perk->description)
                                                            <small class="text-muted">{{ Str::limit($perk->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">No perks assigned to this character.</p>
                        @endif
                    </div>
                </div>

                <!-- Weapons -->
                @if($character->weapons && count($character->weapons) > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">⚔️ Weapons</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($character->weapons as $weapon)
                                    <div class="col-sm-6 col-lg-4 mb-2">
                                        <span class="badge bg-secondary me-1">{{ $weapon }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Objective -->
                @if($character->objective)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">🎯 Objective</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $character->objective }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection