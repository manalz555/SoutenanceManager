<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SoutenanceManager</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <div class="header-left">
            <img src="{{ asset('icons/logo3.png') }}" alt="Logo" class="logo">
            <h1>SoutenanceManager</h1>
        </div>
        <div class="user-info">
            <div class="user-avatar">A</div>
            <span>Administrateur ▼</span>
        </div>
    </header>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <nav>
            <a href="{{ url('/admin/dashboard') }}" class="active">
                <span class="icon">📊</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ url('/admin/etudiants') }}">
                <span class="icon">👨‍🎓</span>
                <span>Étudiants</span>
            </a>
            <a href="{{ url('/admin/professeurs') }}">
                <span class="icon">👨‍🏫</span>
                <span>Professeurs</span>
            </a>
            <a href="{{ url('/admin/assignations') }}">
                <span class="icon">🔗</span>
                <span>Assignations</span>
            </a>
            <a href="{{ url('/admin/validation') }}">
                <span class="icon">✓</span>
                <span>Validation Rapports</span>
            </a>
            <a href="{{ url('/admin/jury') }}">
                <span class="icon">👥</span>
                <span>Formation Jury</span>
            </a>
            <a href="{{ url('/admin/planification') }}">
                <span class="icon">📅</span>
                <span>Planification</span>
            </a>
            <a href="{{ url('/admin/planning') }}">
                <span class="icon">📋</span>
                <span>Planning Global</span>
            </a>
            <a href="{{ url('/logout') }}" class="logout-btn">
                <span class="icon">🚪</span>
                <span>Déconnexion</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <h2 class="page-title">📊 Dashboard Administrateur</h2>

        <!-- CARDS STATS -->
        <div class="cards-container">
            <div class="stat-card blue">
                <div class="stat-icon">👨‍🎓</div>
                <h3>45</h3>
                <p>Étudiants</p>
            </div>
            <div class="stat-card green">
                <div class="stat-icon">👨‍🏫</div>
                <h3>28</h3>
                <p>Professeurs</p>
            </div>
            <div class="stat-card orange">
                <div class="stat-icon">📄</div>
                <h3>32</h3>
                <p>Rapports déposés</p>
            </div>
            <div class="stat-card purple">
                <div class="stat-icon">📅</div>
                <h3>18</h3>
                <p>Soutenances planifiées</p>
            </div>
            <div class="stat-card red">
                <div class="stat-icon">⏳</div>
                <h3>5</h3>
                <p>En attente validation</p>
            </div>
        </div>

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
                            <th>Jury</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>28/01/2025</td>
                            <td>10h00</td>
                            <td>B102</td>
                            <td>Ahmed Benali</td>
                            <td>4 membres</td>
                            <td><span class="badge badge-success">Confirmée</span></td>
                        </tr>
                        <tr>
                            <td>28/01/2025</td>
                            <td>14h00</td>
                            <td>B103</td>
                            <td>Fatima Alami</td>
                            <td>4 membres</td>
                            <td><span class="badge badge-success">Confirmée</span></td>
                        </tr>
                        <tr>
                            <td>29/01/2025</td>
                            <td>09h00</td>
                            <td>A201</td>
                            <td>Youssef Idrissi</td>
                            <td>3 membres</td>
                            <td><span class="badge badge-warning">En attente</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION RAPPORTS EN ATTENTE -->
        <section class="section">
            <h3 class="section-title">⏳ Rapports en attente de validation</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Titre</th>
                            <th>Date dépôt</th>
                            <th>Encadrant</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mohammed Tazi</td>
                            <td>Application Web de Gestion</td>
                            <td>15/01/2025</td>
                            <td>Prof. Alami</td>
                            <td>
                                <button class="btn btn-success btn-sm">Valider</button>
                                <button class="btn btn-secondary btn-sm">Voir</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Sara Bennani</td>
                            <td>Système de Recommandation</td>
                            <td>16/01/2025</td>
                            <td>Prof. Zahra</td>
                            <td>
                                <button class="btn btn-success btn-sm">Valider</button>
                                <button class="btn btn-secondary btn-sm">Voir</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION STATISTIQUES -->
        <section class="section">
            <h3 class="section-title">📈 Statistiques</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div style="background: #f0f7ff; padding: 20px; border-radius: 10px; border-left: 4px solid #4db8ff;">
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">Rapports validés</div>
                    <div style="font-size: 32px; font-weight: bold; color: #1e3a5f;">27 / 32</div>
                    <div style="margin-top: 10px;">
                        <div style="background: #e0e0e0; height: 8px; border-radius: 10px; overflow: hidden;">
                            <div style="background: #4db8ff; height: 100%; width: 84%;"></div>
                        </div>
                    </div>
                </div>
                <div style="background: #f0fdf4; padding: 20px; border-radius: 10px; border-left: 4px solid #4caf50;">
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">Jury constitués</div>
                    <div style="font-size: 32px; font-weight: bold; color: #1e3a5f;">18 / 27</div>
                    <div style="margin-top: 10px;">
                        <div style="background: #e0e0e0; height: 8px; border-radius: 10px; overflow: hidden;">
                            <div style="background: #4caf50; height: 100%; width: 67%;"></div>
                        </div>
                    </div>
                </div>
                <div style="background: #fff5e8; padding: 20px; border-radius: 10px; border-left: 4px solid #ff9800;">
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">Soutenances planifiées</div>
                    <div style="font-size: 32px; font-weight: bold; color: #1e3a5f;">18 / 27</div>
                    <div style="margin-top: 10px;">
                        <div style="background: #e0e0e0; height: 8px; border-radius: 10px; overflow: hidden;">
                            <div style="background: #ff9800; height: 100%; width: 67%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>

