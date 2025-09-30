@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Create New Role</h1>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Back to Roles</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Describe this role...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="symbol_svg" class="form-label">Symbol SVG</label>
                        <textarea class="form-control @error('symbol_svg') is-invalid @enderror" 
                                  id="symbol_svg" name="symbol_svg" rows="3" 
                                  placeholder="Enter SVG code for the role symbol...">{{ old('symbol_svg') }}</textarea>
                        @error('symbol_svg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Optional: Paste SVG code for a custom symbol</small>
                    </div>

                    <div class="mb-3">
                        <label for="perks_included" class="form-label">Included Perks</label>
                        <div class="row">
                            @forelse($perks as $perk)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="perks_included[]" value="{{ $perk->id }}" id="perk_{{ $perk->id }}"
                                               {{ in_array($perk->id, old('perks_included', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perk_{{ $perk->id }}">
                                            {{ $perk->name }}
                                            @if($perk->description)
                                                <br><small class="text-muted">{{ Str::limit($perk->description, 50) }}</small>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted">No perks available. <a href="{{ route('perks.create') }}">Create perks first</a></p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection