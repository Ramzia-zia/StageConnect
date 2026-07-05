@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Modifier l'offre</div>
                <div class="card-body">
                    <form action="{{ route('offers.update', $offer) }}" method="POST">
                        @csrf @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre du poste</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $offer->title) }}" required>
                            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="city" class="form-label">Ville</label>
                                <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $offer->city) }}" required>
                                @error('city')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="duration" class="form-label">Durée</label>
                                <input type="text" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration', $offer->duration) }}" required>
                                @error('duration')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label">Rémunération</label>
                            <input type="text" name="salary" id="salary" class="form-control" value="{{ old('salary', $offer->salary) }}">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $offer->description) }}</textarea>
                            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="requirements" class="form-label">Prérequis</label>
                            <textarea name="requirements" id="requirements" rows="4" class="form-control @error('requirements') is-invalid @enderror" required>{{ old('requirements', $offer->requirements) }}</textarea>
                            @error('requirements')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection