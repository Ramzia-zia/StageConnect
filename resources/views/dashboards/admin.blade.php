@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white bg-danger">Tableau de bord Administrateur</div>
                <div class="card-body">
                    <h5 class="card-title">Bienvenue, {{ Auth::user()->name }}</h5>
                    <p class="card-text">Fonctionnalités à venir : Statistiques, modération, gestion des utilisateurs.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection