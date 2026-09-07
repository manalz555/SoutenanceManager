<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace étudiant') - SoutenanceManager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/etudiant.css') }}">
    <style>
        .muted { color: #999; font-size: 13px; }
        .empty { color: #777; padding: 20px; text-align: center; }
        .inline-form { display: inline; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; box-sizing: border-box; }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('icons/logo3.png') }}" alt="Logo" class="logo">
            <h1>SoutenanceManager</h1>
        </div>
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr($currentEtudiant->prenom ?? 'E', 0, 1)) }}</div>
            <span>{{ isset($currentEtudiant) ? $currentEtudiant->full_name : 'Étudiant' }}</span>
        </div>
    </header>

    <aside class="sidebar">
        <nav>
            <a href="{{ route('etudiant.dashboard') }}" class="{{ request()->is('etudiant/dashboard') ? 'active' : '' }}">
                <i class="fa-regular fa-chart-bar"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('etudiant.depot') }}" class="{{ request()->is('etudiant/depot*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-arrow-up"></i><span>Dépôt de documents</span>
            </a>
            <a href="{{ route('etudiant.remarques') }}" class="{{ request()->is('etudiant/remarques*') ? 'active' : '' }}">
                <i class="fa-regular fa-comments"></i><span>Mes remarques</span>
            </a>
            <a href="{{ route('etudiant.soutenance') }}" class="{{ request()->is('etudiant/soutenance*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i><span>Ma soutenance</span>
            </a>
            <a href="{{ route('logout') }}" class="logout-btn">
                <i class="fa-solid fa-arrow-right-from-bracket"></i><span>Déconnexion</span>
            </a>
        </nav>
    </aside>

    <main class="main-content">
        @include('partials.flash')
        @yield('content')
    </main>

    <script src="{{ asset('js/etudiant.js') }}"></script>
    @yield('scripts')
</body>
</html>
