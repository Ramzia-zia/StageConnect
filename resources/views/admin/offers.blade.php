@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Modération des offres</h3>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Entreprise</th>
                    <th>Titre</th>
                    <th>Ville</th>
                    <th>Date de soumission</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($offers as $offer)
                    <tr>
                        <td>{{ $offer->company->name }}</td>
                        <td>{{ $offer->title }}</td>
                        <td>{{ $offer->city }}</td>
                        <td>{{ $offer->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.validate', $offer) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Valider cette offre ?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Valider</button>
                            </form>
                            <form action="{{ route('admin.destroyOffer', $offer) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Supprimer définitivement ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Refuser/Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">{{ $offers->links() }}</div>
</div>
@endsection