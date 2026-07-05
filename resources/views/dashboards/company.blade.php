@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Tableau de bord Entreprise</h3>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Mes Offres</h5>
                    <h2>{{ Auth::user()->company->offers->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Candidatures reçues</h5>
                    <h2>{{ \App\Models\Application::whereIn('offer_id', Auth::user()->company->offers->pluck('id'))->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-end mt-3">
            <a href="{{ route('offers.index') }}" class="btn btn-lg btn-primary">Gérer mes offres</a>
        </div>
    </div>
</div>
@endsection