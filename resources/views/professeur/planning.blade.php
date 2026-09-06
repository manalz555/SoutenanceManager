<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning - SoutenanceManager</title>
    <link rel="stylesheet" href="{{ asset('css/professeur.css') }}">
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('icons/logo3.png') }}" alt="Logo" class="logo">
            <h1>SoutenanceManager</h1>
        </div>
        <div class="user-info">
            <div class="user-avatar">P</div>
            <span>Prof. Alami ▼</span>
        </div>
    </header>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <nav>
            <a href="{{ url('/professeur/dashboard') }}">
                <span class="icon">📊</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ url('/professeur/etudiants') }}">
                <span class="icon">👨‍🎓</span>
                <span>Mes Étudiants</span>
            </a>
            <a href="{{ url('/professeur/feedback') }}">
                <span class="icon">💬</span>
                <span>Feedback</span>
            </a>
            <a href="{{ url('/professeur/planning') }}" class="active">
                <span class="icon">📅</span>
                <span>Planning</span>
            </a>
            <a href="{{ url('/logout') }}" class="logout-btn">
                <span class="icon">🚪</span>
                <span>Déconnexion</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <h2 class="page-title">📅 Planning des Soutenances</h2>

        <div class="filters" style="margin-bottom: 25px;">
            <button class="filter-btn active" onclick="filterByRole('all')">Tous mes rôles</button>
            <button class="filter-btn" onclick="filterByRole('encadrant')">Encadrant</button>
            <button class="filter-btn" onclick="filterByRole('rapporteur')">Rapporteur</button>
            <button class="filter-btn" onclick="filterByRole('examinateur')">Examinateur</button>
            <button class="filter-btn" onclick="filterByRole('president')">Président</button>
        </div>

        <!-- TABLE -->
        <section class="section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Salle</th>
                            <th>Étudiant</th>
                            <th>Mon rôle</th>
                            <th>Jury</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-role="encadrant">
                            <td><strong>28/01/2025</strong></td>
                            <td>10h00 - 10h45</td>
                            <td>B102</td>
                            <td><strong>Ahmed Benali</strong></td>
                            <td><span class="badge badge-info">Encadrant</span></td>
                            <td>4 membres</td>
                        </tr>
                        <tr data-role="rapporteur">
                            <td><strong>28/01/2025</strong></td>
                            <td>14h00 - 14h45</td>
                            <td>B103</td>
                            <td><strong>Fatima Alami</strong></td>
                            <td><span class="badge badge-warning">Rapporteur</span></td>
                            <td>4 membres</td>
                        </tr>
                        <tr data-role="examinateur">
                            <td><strong>29/01/2025</strong></td>
                            <td>11h00 - 11h45</td>
                            <td>A202</td>
                            <td><strong>Mohammed Tazi</strong></td>
                            <td><span class="badge badge-info">Examinateur</span></td>
                            <td>4 membres</td>
                        </tr>
                        <tr data-role="encadrant">
                            <td><strong>30/01/2025</strong></td>
                            <td>09h00 - 09h45</td>
                            <td>A201</td>
                            <td><strong>Youssef Idrissi</strong></td>
                            <td><span class="badge badge-info">Encadrant</span></td>
                            <td>4 membres</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/professeur.js') }}"></script>
    <script>
        function filterByRole(role) {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                if (role === 'all') {
                    row.style.display = '';
                } else {
                    row.style.display = row.dataset.role === role ? '' : 'none';
                }
            });
        }
    </script>
</body>
</html>

