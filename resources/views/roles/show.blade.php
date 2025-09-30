@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">{{ $role->name }}</h1>
            <div>
                <a href="{{ route('roles.edit', $role) }}" class="btn btn-outline-primary me-2">Edit</a>
                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Back to Roles</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($role->symbol_svg)
                            <div class="mb-3" style="font-size: 4rem;">
                                {!! $role->symbol_svg !!}
                            </div>
                        @endif
                        
                        <h3>{{ $role->name }}</h3>
                        
                        @if($role->description)
                            <p class="text-muted">{{ $role->description }}</p>
                        @endif
                        
                        <div class="mt-4">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h4 class="text-primary">{{ $role->characters->count() }}</h4>
                                        <small class="text-muted">Characters</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success">{{ $role->perksIncluded->count() }}</h4>
                                    <small class="text-muted">Perks</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Included Perks -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">⭐ Included Perks</h5>
                    </div>
                    <div class="card-body">
                        @if($role->perksIncluded->count() > 0)
                            <div class="row">
                                @foreach($role->perksIncluded as $perk)
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
                            <p class="text-muted mb-0">No perks included in this role.</p>
                        @endif
                    </div>
                </div>

                <!-- Characters with this Role -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">🗡️ Characters with this Role</h5>
                    </div>
                    <div class="card-body">
                        @if($role->characters->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Character</th>
                                            <th>Owner</th>
                                            <th>Current World</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($role->characters as $character)
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
                            <p class="text-muted mb-0">No characters have this role yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection