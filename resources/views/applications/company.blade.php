@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Candidatures pour : {{ $offer->title }}</h3>
        <a href="{{ route('offers.index') }}" class="btn btn-outline-secondary">Retour</a>
    </div>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row">
        @forelse($applications as $application)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $application->student->name }}</h5>
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
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-2">{{ $application->created_at->format('d/m/Y H:i') }}</p>
                        <h6>Lettre de motivation :</h6>
                        <p class="bg-light p-3 rounded" style="white-space: pre-wrap;">{{ $application->cover_letter_custom }}</p>
                        
                        @if($application->student->profile)
                            <div class="mt-3">
                                <strong>Téléphone :</strong> {{ $application->student->profile->phone ?? 'Non renseigné' }}<br>
                                @if($application->student->profile->cv_path)
                                    <a href="{{ Storage::url($application->student->profile->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Voir le CV (PDF)</a>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white">
                        <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="d-flex gap-2 align-items-center">
                            @csrf @method('PUT')
                            <select name="status" class="form-select form-select-sm w-auto">
                                <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="interview" {{ $application->status === 'interview' ? 'selected' : '' }}>Entretien</option>
                                <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepter</option>
                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Refuser</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-success">Mettre à jour</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Aucune candidature pour cette offre.</div>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">{{ $applications->links() }}</div>
</div>
@endsection