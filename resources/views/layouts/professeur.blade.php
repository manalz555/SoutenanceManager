<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace professeur') - SoutenanceManager</title>
    <link rel="stylesheet" href="{{ asset('css/professeur.css') }}">
    <style>
        .alert-danger { background: #fdecea; color: #b71c1c; border-left: 4px solid #e53935; }
        .badge-danger { background: #fdecea; color: #b71c1c; }
        .btn-danger { background: #e53935; color: #fff; }
        .inline-form { display: inline; }
        .muted { color: #999; font-size: 13px; }
        .empty { color: #777; padding: 20px; text-align: center; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px 14px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; box-sizing: border-box; }
        .form-group textarea { min-height: 90px; }
        .note-form { display: flex; gap: 8px; align-items: center; }
        .note-form input[type=number] { width: 70px; padding: 6px; border: 1px solid #e0e0e0; border-radius: 5px; }
        .note-form input[type=text] { padding: 6px; border: 1px solid #e0e0e0; border-radius: 5px; }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('icons/logo3.png') }}" alt="Logo" class="logo">
            <h1>SoutenanceManager</h1>
        </div>
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr($currentProfessor->prenom_prof ?? 'P', 0, 1)) }}</div>
            <span>{{ isset($currentProfessor) ? 'Prof. '.$currentProfessor->nom_prof : 'Professeur' }}</span>
        </div>
    </header>

    <aside class="sidebar">
        <nav>
            <a href="{{ route('professor.dashboard') }}" class="{{ request()->is('professeur/dashboard') ? 'active' : '' }}">
                <span class="icon">📊</span><span>Dashboard</span>
            </a>
            <a href="{{ route('professor.etudiants') }}" class="{{ request()->is('professeur/etudiants*') ? 'active' : '' }}">
                <span class="icon">👨‍🎓</span><span>Mes Étudiants</span>
            </a>
            <a href="{{ route('professor.planning') }}" class="{{ request()->is('professeur/planning*') ? 'active' : '' }}">
                <span class="icon">📅</span><span>Planning &amp; Notes</span>
            </a>
            <a href="{{ route('logout') }}" class="logout-btn">
                <span class="icon">🚪</span><span>Déconnexion</span>
            </a>
        </nav>
    </aside>

    <main class="main-content">
        @include('partials.flash')
        @yield('content')
    </main>

    <script src="{{ asset('js/professeur.js') }}"></script>
    @yield('scripts')
</body>
</html>
