<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StageConnect - Trouvez le stage de vos rêves</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
            color: white;
            padding: 100px 0;
        }
        .features-section { padding: 60px 0; background-color: #f8f9fa; }
        .feature-icon { font-size: 3rem; color: #0d6efd; margin-bottom: 15px; }
        footer { background-color: #343a40; color: white; padding: 20px 0; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/"><i class="bi bi-mortarboard-fill me-2"></i>StageConnect</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="/">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('offers.public.index') }}">Offres de stage</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light btn-sm me-2" href="{{ route('login') }}">Connexion</a>
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">S'inscrire</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Trouvez le stage de vos rêves ou recrutez les meilleurs talents</h1>
            <p class="lead mb-5">La plateforme n°1 pour mettre en relation étudiants et entreprises. Simple, rapide et efficace.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">Je cherche un stage</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Je propose un stage</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container text-center">
            <h2 class="mb-5 fw-bold">Pourquoi choisir StageConnect ?</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <i class="bi bi-search-heart feature-icon"></i>
                    <h5>Recherche intelligente</h5>
                    <p class="text-muted">Trouvez des offres correspondant exactement à votre profil, votre ville et vos compétences.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="bi bi-file-earmark-person feature-icon"></i>
                    <h5>Candidature facile</h5>
                    <p class="text-muted">Postulez en un clic avec votre CV et une lettre de motivation personnalisée.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="bi bi-shield-check feature-icon"></i>
                    <h5>Offres vérifiées</h5>
                    <p class="text-muted">Toutes les offres sont modérées par notre équipe pour garantir la sécurité des étudiants.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 text-center bg-white">
        <div class="container">
            <h3 class="fw-bold mb-3">Prêt à commencer ?</h3>
            <p class="text-muted mb-4">Rejoignez des milliers d'étudiants et d'entreprises qui nous font confiance.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Créer un compte maintenant</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} StageConnect. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>