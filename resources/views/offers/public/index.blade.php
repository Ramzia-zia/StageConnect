@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Offres de stage disponibles</h2>

    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('offers.public.index') }}" method="GET" class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Rechercher par titre, ville..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
            </form>
        </div>
        <div class="col-md-3">
            <form action="{{ route('offers.public.index') }}" method="GET">
                <select name="city" class="form-select" onchange="this.form.submit()">
                    <option value="">Toutes les villes</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($offers as $offer)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary">{{ \Illuminate\Support\Str::limit($offer->title, 40) }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $offer->company->name }} - {{ $offer->city }}</h6>
                        <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($offer->description, 100) }}...</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="badge bg-info">{{ $offer->duration }}</span>
                            <a href="{{ route('offers.public.show', $offer) }}" class="btn btn-sm btn-outline-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">Aucune offre ne correspond à votre recherche.</div>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">{{ $offers->links() }}</div>
</div>
@endsection