<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Professeur - SoutenanceManager</title>
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
            <a href="{{ url('/professeur/dashboard') }}" class="active">
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
            <a href="{{ url('/professeur/planning') }}">
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
        <h2 class="page-title">📊 Dashboard Professeur</h2>

        <!-- CARDS STATS -->
        <div class="cards-container">
            <div class="stat-card blue">
                <div class="stat-icon">👨‍🎓</div>
                <h3>8</h3>
                <p>Étudiants encadrés</p>
            </div>
            <div class="stat-card green">
                <div class="stat-icon">📄</div>
                <h3>6</h3>
                <p>Rapports reçus</p>
            </div>
            <div class="stat-card orange">
                <div class="stat-icon">💬</div>
                <h3>12</h3>
                <p>Remarques données</p>
            </div>
            <div class="stat-card purple">
                <div class="stat-icon">📅</div>
                <h3>5</h3>
                <p>Soutenances à venir</p>
            </div>
        </div>

        <!-- SECTION MES RÔLES -->
        <section class="section">
            <h3 class="section-title">🎭 Mes rôles</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div style="background: #f0f7ff; padding: 20px; border-radius: 10px; border-left: 4px solid #4db8ff; text-align: center;">
                    <div style="font-size: 32px; margin-bottom: 10px;">👨‍🏫</div>
                    <div style="font-weight: 600; color: #1e3a5f; margin-bottom: 5px;">Encadrant</div>
                    <div style="color: #666; font-size: 14px;">8 étudiants</div>
                </div>
                <div style="background: #fff5e8; padding: 20px; border-radius: 10px; border-left: 4px solid #ff9800; text-align: center;">
                    <div style="font-size: 32px; margin-bottom: 10px;">📝</div>
                    <div style="font-weight: 600; color: #1e3a5f; margin-bottom: 5px;">Rapporteur</div>
                    <div style="color: #666; font-size: 14px;">5 étudiants</div>
                </div>
                <div style="background: #f5e8ff; padding: 20px; border-radius: 10px; border-left: 4px solid #9c27b0; text-align: center;">
                    <div style="font-size: 32px; margin-bottom: 10px;">🔍</div>
                    <div style="font-weight: 600; color: #1e3a5f; margin-bottom: 5px;">Examinateur</div>
                    <div style="color: #666; font-size: 14px;">3 étudiants</div>
                </div>
                <div style="background: #fff5e8; padding: 20px; border-radius: 10px; border-left: 4px solid #ffd700; text-align: center;">
                    <div style="font-size: 32px; margin-bottom: 10px;">👑</div>
                    <div style="font-weight: 600; color: #1e3a5f; margin-bottom: 5px;">Président</div>
                    <div style="color: #666; font-size: 14px;">2 étudiants</div>
                </div>
            </div>
        </section>

        <!-- SECTION RAPPORTS RÉCENTS -->
        <section class="section">
            <h3 class="section-title">📄 Rapports récemment reçus</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Titre</th>
                            <th>Date réception</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ahmed Benali</td>
                            <td>Application Web de Gestion</td>
                            <td>15/01/2025</td>
                            <td><span class="badge badge-info">Encadrant</span></td>
                            <td><span class="badge badge-warning">En révision</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="viewReport(1)">Voir</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Fatima Alami</td>
                            <td>Système de Recommandation</td>
                            <td>10/01/2025</td>
                            <td><span class="badge badge-warning">Rapporteur</span></td>
                            <td><span class="badge badge-success">Validé</span></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="viewReport(2)">Voir</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION PROCHAINES SOUTENANCES -->
        <section class="section">
            <h3 class="section-title">📅 Prochaines soutenances</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Salle</th>
                            <th>Étudiant</th>
                            <th>Rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>28/01/2025</td>
                            <td>10h00</td>
                            <td>B102</td>
                            <td>Ahmed Benali</td>
                            <td><span class="badge badge-info">Encadrant</span></td>
                        </tr>
                        <tr>
                            <td>28/01/2025</td>
                            <td>14h00</td>
                            <td>B103</td>
                            <td>Fatima Alami</td>
                            <td><span class="badge badge-warning">Rapporteur</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/professeur.js') }}"></script>
    <script>
        function viewReport(id) {
            window.location.href = '/professeur/rapports/' + id;
        }
    </script>
</body>
</html>

