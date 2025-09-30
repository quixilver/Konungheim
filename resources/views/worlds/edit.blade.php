@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Edit {{ $world->name }}</h1>
            <a href="{{ route('worlds.show', $world) }}" class="btn btn-outline-secondary">Back to World</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('worlds.update', $world) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $world->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="seed" class="form-label">World Seed</label>
                        <input type="text" class="form-control @error('seed') is-invalid @enderror" 
                               id="seed" name="seed" value="{{ old('seed', $world->seed) }}" placeholder="Enter the world seed...">
                        @error('seed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">The seed used to generate this Valheim world</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Describe this world...">{{ old('description', $world->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="traits" class="form-label">World Traits</label>
                        <div id="traits-container">
                            @if($world->traits && count($world->traits) > 0)
                                @foreach($world->traits as $trait)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="traits[]" value="{{ $trait }}">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeTrait(this)">-</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="traits[]" placeholder="Enter world trait">
                                    <button type="button" class="btn btn-outline-secondary" onclick="addTrait()">+</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addTrait()">Add Trait</button>
                        <small class="text-muted d-block">Add special traits or characteristics of this world</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('worlds.show', $world) }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update World</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function addTrait() {
    const container = document.getElementById('traits-container');
    const newTrait = document.createElement('div');
    newTrait.className = 'input-group mb-2';
    newTrait.innerHTML = `
        <input type="text" class="form-control" name="traits[]" placeholder="Enter world trait">
        <button type="button" class="btn btn-outline-danger" onclick="removeTrait(this)">-</button>
    `;
    container.appendChild(newTrait);
}

function removeTrait(button) {
    button.parentElement.remove();
}
</script>
@endsection