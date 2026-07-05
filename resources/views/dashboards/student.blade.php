@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Tableau de bord Étudiant</h3>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Offres disponibles</h5>
                    <h2>{{ \App\Models\Offer::where('is_active', true)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Mes candidatures</h5>
                    <h2>{{ Auth::user()->applications->count() }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="text-end">
        <a href="{{ route('offers.public.index') }}" class="btn btn-lg btn-primary">Chercher un stage</a>
        <a href="{{ route('applications.my') }}" class="btn btn-lg btn-secondary">Mes candidatures</a>
    </div>
</div>
@endsection