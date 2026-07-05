<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts Vite (pour ton CSS personnalisé si tu en as) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <i class="bi bi-mortarboard-fill me-2 text-primary"></i>StageConnect
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('offers.public.index') }}">Offres de stage</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">S'inscrire</a>
                            </li>
                        @else
                            <!-- Icône Notifications -->
                            <li class="nav-item dropdown me-3">
                                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bell text-dark"></i>
                                    <span id="notification-count" class="badge bg-danger rounded-pill" style="display: none;">0</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="min-width: 300px;">
                                    <li><h6 class="dropdown-header">Notifications</h6></li>
                                    <li id="notification-list">
                                        <span class="dropdown-item text-muted text-center">Chargement...</span>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('notifications.readAll') }}" method="POST" class="px-3">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-link text-primary p-0">Tout marquer comme lu</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>

                            <!-- Menu Utilisateur -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-gear me-2"></i>Mon Profil
                                    </a>
                                    <a class="dropdown-item" href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : (Auth::user()->role === 'company' ? route('company.dashboard') : route('student.dashboard')) }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    
                                    <!-- Formulaire de déconnexion -->
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-left me-2"></i>Déconnexion
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5 JS (OBLIGATOIRE pour que les menus déroulants fonctionnent) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @auth
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const countEl = document.getElementById('notification-count');
        const listEl = document.getElementById('notification-list');

        function loadNotifications() {
            fetch('{{ route("notifications.index") }}')
                .then(res => res.json())
                .then(data => {
                    countEl.innerText = data.length;
                    countEl.style.display = data.length > 0 ? 'inline' : 'none';

                    if (data.length === 0) {
                        listEl.innerHTML = '<span class="dropdown-item text-muted text-center">Aucune notification</span>';
                    } else {
                        listEl.innerHTML = data.map(n => `
                            <a class="dropdown-item ${n.read_at ? '' : 'bg-light fw-bold'}" href="${n.data.action_url}" onclick="markRead(${n.id})" style="white-space: normal; font-size: 0.9em;">
                                ${n.data.message}
                            </a>
                        `).join('');
                    }
                }).catch(() => {
                    listEl.innerHTML = '<span class="dropdown-item text-muted text-center">Erreur de chargement</span>';
                });
        }

        window.markRead = function(id) {
            fetch('{{ route("notifications.read") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ id: id })
            }).then(() => loadNotifications());
        };

        loadNotifications();
        setInterval(loadNotifications, 30000);
    });
    </script>
    @endauth

</body>
</html>