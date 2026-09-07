<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - SoutenanceManager</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .alert-danger { background: #fdecea; color: #b71c1c; border-left: 4px solid #e53935; }
        .select-inline { padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px; width: 100%; }
        .inline-form { display: inline; }
        .muted { color: #999; font-size: 13px; }
        .progress-track { background: #e0e0e0; height: 8px; border-radius: 10px; overflow: hidden; }
        .progress-fill { height: 100%; }
        .empty { color: #777; padding: 20px; text-align: center; }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('icons/logo3.png') }}" alt="Logo" class="logo">
            <h1>SoutenanceManager</h1>
        </div>
        <div class="user-info">
            <div class="user-avatar">A</div>
            <span>Administrateur</span>
        </div>
    </header>

    <aside class="sidebar">
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <span class="icon">📊</span><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.students') }}" class="{{ request()->is('admin/etudiants*') ? 'active' : '' }}">
                <span class="icon">👨‍🎓</span><span>Étudiants</span>
            </a>
            <a href="{{ route('admin.teachers') }}" class="{{ request()->is('admin/professeurs*') ? 'active' : '' }}">
                <span class="icon">👨‍🏫</span><span>Professeurs</span>
            </a>
            <a href="{{ route('admin.assignations') }}" class="{{ request()->is('admin/assignations*') ? 'active' : '' }}">
                <span class="icon">🔗</span><span>Assignations</span>
            </a>
            <a href="{{ route('admin.validation') }}" class="{{ request()->is('admin/validation*') ? 'active' : '' }}">
                <span class="icon">✓</span><span>Validation Rapports</span>
            </a>
            <a href="{{ route('admin.defenses') }}" class="{{ request()->is('admin/soutenances*') ? 'active' : '' }}">
                <span class="icon">📅</span><span>Soutenances &amp; Jurys</span>
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

    <script src="{{ asset('js/admin.js') }}"></script>
    @yield('scripts')
</body>
</html>
