@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Mes candidatures</h3>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Offre</th>
                    <th>Entreprise</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{ $application->offer->title }}</td>
                        <td>{{ $application->offer->company->name }}</td>
                        <td>{{ $application->created_at->format('d/m/Y') }}</td>
                        <td>
                            @switch($application->status)
                                @case('pending')
                                    <span class="badge bg-warning text-dark">En attente</span>
                                @break
                                @case('interview')
                                    <span class="badge bg-info">Entretien</span>
                                @break
                                @case('accepted')
                                    <span class="badge bg-success">Acceptée</span>
                                @break
                                @case('rejected')
                                    <span class="badge bg-danger">Refusée</span>
                                @break
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">{{ $applications->links() }}</div>
</div>
@endsection