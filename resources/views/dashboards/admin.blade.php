@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Administration - Vue d'ensemble</h3>
    
    <div class="row mb-4">
        <div class="col-md-2 mb-3">
            <div class="card text-white bg-primary shadow-sm text-center">
                <div class="card-body">
                    <h6>Étudiants</h6>
                    <h2>{{ $stats['students'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card text-white bg-success shadow-sm text-center">
                <div class="card-body">
                    <h6>Entreprises</h6>
                    <h2>{{ $stats['companies'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning shadow-sm text-center">
                <div class="card-body">
                    <h6>Offres en attente</h6>
                    <h2>{{ $stats['offers_pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card text-white bg-info shadow-sm text-center">
                <div class="card-body">
                    <h6>Offres actives</h6>
                    <h2>{{ $stats['offers_active'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-dark shadow-sm text-center">
                <div class="card-body">
                    <h6>Candidatures</h6>
                    <h2>{{ $stats['applications'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Modération</h5>
                    <a href="{{ route('admin.offers') }}" class="btn btn-sm btn-warning">Voir offres en attente</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Utilisateurs</h5>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-secondary">Gérer</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white"><h5 class="mb-0">Dernières candidatures</h5></div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Étudiant</th><th>Offre</th><th>Entreprise</th><th>Date</th></tr>
                </thead>
                <tbody>
                    @foreach($recentApplications as $app)
                        <tr>
                            <td>{{ $app->student->name }}</td>
                            <td>{{ $app->offer->title }}</td>
                            <td>{{ $app->offer->company->name }}</td>
                            <td>{{ $app->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection