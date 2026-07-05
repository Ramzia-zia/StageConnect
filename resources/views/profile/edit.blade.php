@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Modifier mon profil</div>
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Infos de base communes -->
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nom complet</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">E-mail</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        @if($user->role === 'student')
                            <!-- Champs Étudiant -->
                            <hr>
                            <div class="row mb-3">
                                <label for="phone" class="col-md-4 col-form-label text-md-end">Téléphone</label>
                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="education_level" class="col-md-4 col-form-label text-md-end">Niveau d'études</label>
                                <div class="col-md-6">
                                    <input id="education_level" type="text" class="form-control" name="education_level" value="{{ old('education_level', $user->profile->education_level ?? '') }}" placeholder="Ex: Bac+3, Licence...">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="skills" class="col-md-4 col-form-label text-md-end">Compétences</label>
                                <div class="col-md-6">
                                    <input id="skills" type="text" class="form-control" name="skills[]" value="{{ old('skills', $user->profile->skills ? implode(',', $user->profile->skills) : '') }}" placeholder="Ex: PHP, Laravel, MySQL (séparées par des virgules)">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="bio" class="col-md-4 col-form-label text-md-end">Biographie</label>
                                <div class="col-md-6">
                                    <textarea id="bio" class="form-control" name="bio" rows="3">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="avatar" class="col-md-4 col-form-label text-md-end">Photo de profil</label>
                                <div class="col-md-6">
                                    <input id="avatar" type="file" class="form-control" name="avatar">
                                    @if($user->profile && $user->profile->avatar)
                                        <img src="{{ Storage::url($user->profile->avatar) }}" alt="Avatar" class="mt-2 rounded" width="80">
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="cv" class="col-md-4 col-form-label text-md-end">CV (PDF)</label>
                                <div class="col-md-6">
                                    <input id="cv" type="file" class="form-control" name="cv" accept=".pdf">
                                    @if($user->profile && $user->profile->cv_path)
                                        <a href="{{ Storage::url($user->profile->cv_path) }}" target="_blank" class="mt-2 d-block">Voir le CV actuel</a>
                                    @endif
                                </div>
                            </div>

                        @elseif($user->role === 'company')
                            <!-- Champs Entreprise -->
                            <hr>
                            <div class="row mb-3">
                                <label for="company_name" class="col-md-4 col-form-label text-md-end">Nom de l'entreprise</label>
                                <div class="col-md-6">
                                    <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name', $user->company->name ?? '') }}" required>
                                    @error('company_name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="siret" class="col-md-4 col-form-label text-md-end">SIRET</label>
                                <div class="col-md-6">
                                    <input id="siret" type="text" class="form-control" name="siret" value="{{ old('siret', $user->company->siret ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="sector" class="col-md-4 col-form-label text-md-end">Secteur d'activité</label>
                                <div class="col-md-6">
                                    <input id="sector" type="text" class="form-control" name="sector" value="{{ old('sector', $user->company->sector ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="city" class="col-md-4 col-form-label text-md-end">Ville</label>
                                <div class="col-md-6">
                                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', $user->company->city ?? '') }}" required>
                                    @error('city')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="website" class="col-md-4 col-form-label text-md-end">Site web</label>
                                <div class="col-md-6">
                                    <input id="website" type="url" class="form-control" name="website" value="{{ old('website', $user->company->website ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="logo" class="col-md-4 col-form-label text-md-end">Logo</label>
                                <div class="col-md-6">
                                    <input id="logo" type="file" class="form-control" name="logo">
                                    @if($user->company && $user->company->logo)
                                        <img src="{{ Storage::url($user->company->logo) }}" alt="Logo" class="mt-2" width="100">
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection