<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Étudiant') - SoutenanceManager</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/etudiant.css') }}">
</head>
<body>
    
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('icons/logo3.png') }}" alt="Logo" class="logo">
            <h1>SoutenanceManager</h1>
        </div>
        
        <div class="user-info">
            <div class="user-avatar">E</div>
            <span>Étudiant ▼</span>
        </div>
    </header>

    
    <aside class="sidebar">
        <nav>
            
            <a href="{{ url('/etudiant/dashboard') }}" class="{{ request()->is('etudiant/dashboard') ? 'active' : '' }}">
                <i class="fa-regular fa-chart-bar"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ url('/etudiant/depot') }}" class="{{ request()->is('etudiant/depot*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-arrow-up"></i>
                <span>Dépôt de rapport</span>
            </a>
            
            <a href="{{ url('/etudiant/remarques') }}" class="{{ request()->is('etudiant/remarques*') ? 'active' : '' }}">
                <i class="fa-regular fa-comments"></i>
                <span>Mes remarques</span>
            </a>
            
            <a href="{{ url('/etudiant/soutenance') }}" class="{{ request()->is('etudiant/soutenance*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Ma soutenance</span>
            </a>
            
            <a href="{{ url('/logout') }}" class="logout-btn">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Déconnexion</span>
            </a>
        </nav>
    </aside>

 
    <main class="main-content">
        @yield('content')
    </main>

    
    <script src="{{ asset('js/etudiant.js') }}"></script>
    
    @yield('scripts')
</body>
</html>