@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Mes offres de stage</h3>
        <a href="{{ route('offers.create') }}" class="btn btn-success">Publier une offre</a>
    </div>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Titre</th>
                    <th>Ville</th>
                    <th>Durée</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($offers as $offer)
                    <tr>
                        <td>{{ $offer->title }}</td>
                        <td>{{ $offer->city }}</td>
                        <td>{{ $offer->duration }}</td>
                        <td>
                            @if($offer->is_active)
                                <span class="badge bg-success">Publiée</span>
                            @else
                                <span class="badge bg-warning text-dark">En attente</span>
                            @endif
                        </td>
                        <td>
                           <a href="{{ route('offers.applications.offer', $offer) }}" class="btn btn-sm btn-info">Voir candidatures ({{ $offer->applications_count }})</a>
                            <a href="{{ route('offers.edit', $offer) }}" class="btn btn-sm btn-primary">Modifier</a>
                            <form action="{{ route('offers.destroy', $offer) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">{{ $offers->links() }}</div>
</div>
@endsection