@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Edit {{ $perk->name }}</h1>
            <a href="{{ route('perks.show', $perk) }}" class="btn btn-outline-secondary">Back to Perk</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('perks.update', $perk) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $perk->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Describe this perk and its effects...">{{ old('description', $perk->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="symbol_svg" class="form-label">Symbol SVG</label>
                        <textarea class="form-control @error('symbol_svg') is-invalid @enderror" 
                                  id="symbol_svg" name="symbol_svg" rows="3" 
                                  placeholder="Enter SVG code for the perk symbol...">{{ old('symbol_svg', $perk->symbol_svg) }}</textarea>
                        @error('symbol_svg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Optional: Paste SVG code for a custom symbol</small>
                        @if($perk->symbol_svg)
                            <div class="mt-2">
                                <small class="text-muted">Current symbol:</small>
                                <div class="symbol-svg">{!! $perk->symbol_svg !!}</div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('perks.show', $perk) }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Perk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection