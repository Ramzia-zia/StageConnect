@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Gestion des utilisateurs</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Inscrit le</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @switch($user->role)
                                @case('admin') <span class="badge bg-danger">Admin</span> @break
                                @case('company') <span class="badge bg-success">Entreprise</span> @break
                                @default <span class="badge bg-primary">Étudiant</span> @break
                            @endswitch
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">{{ $users->links() }}</div>
</div>
@endsection