@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="mb-0">{{ $offer->title }}</h3>
                    <p class="text-muted mb-0 mt-2">{{ $offer->company->name }} - {{ $offer->city }}</p>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p style="white-space: pre-wrap;">{{ $offer->description }}</p>
                    </div>
                    <div class="mb-4">
                        <h5>Prérequis</h5>
                        <p style="white-space: pre-wrap;">{{ $offer->requirements }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center">
                    @if($offer->company->logo)
                        <img src="{{ Storage::url($offer->company->logo) }}" alt="Logo" class="img-fluid mb-3" style="max-height: 100px;">
                    @endif
                    <h5>{{ $offer->company->name }}</h5>
                    <p class="text-muted">{{ $offer->company->sector }}</p>
                </div>
            </div>

                        <div class="card shadow-sm bg-light">
                @if(session('error'))
                    <div class="alert alert-danger m-3">{{ session('error') }}</div>
                @endif

                <div class="card-body">

            <div class="card shadow-sm bg-light">
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>Durée :</strong> {{ $offer->duration }}</li>
                        <li class="mb-2"><strong>Rémunération :</strong> {{ $offer->salary ?? 'Non renseigné' }}</li>
                    </ul>
                    <hr>
                    @if(auth()->check() && auth()->user()->role === 'student')
                        @if($hasApplied)
                            <div class="alert alert-success text-center mb-0">Vous avez déjà postulé.</div>
                        @else
                            <form action="{{ route('apply') }}" method="POST" id="applyForm">
                                @csrf
                                <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Lettre de motivation</label>
                                    <textarea name="cover_letter_custom" class="form-control" rows="6" required placeholder="Expliquez pourquoi vous êtes le candidat idéal..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Postuler</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Connectez-vous pour postuler</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection