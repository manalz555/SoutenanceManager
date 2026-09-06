<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation des Rapports - SoutenanceManager</title>
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
            <a href="{{ url('/admin/dashboard') }}">
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
            <a href="{{ url('/admin/validation') }}" class="active">
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
        <h2 class="page-title">✓ Validation des Rapports</h2>

        <div class="filters">
            <button class="filter-btn active" onclick="filterReports('all')">Tous</button>
            <button class="filter-btn" onclick="filterReports('pending')">En attente</button>
            <button class="filter-btn" onclick="filterReports('validated')">Validés</button>
            <button class="filter-btn" onclick="filterReports('rejected')">Rejetés</button>
        </div>

        <!-- TABLE -->
        <section class="section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Titre du rapport</th>
                            <th>Date dépôt</th>
                            <th>Encadrant</th>
                            <th>Rapporteur</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-status="pending">
                            <td>Ahmed Benali</td>
                            <td>Application Web de Gestion</td>
                            <td>15/01/2025</td>
                            <td>Prof. Zahra</td>
                            <td>Dr. Alami</td>
                            <td><span class="badge badge-warning">En attente</span></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="validateReport(1)">Valider</button>
                                <button class="btn btn-secondary btn-sm" onclick="viewReport(1)">Voir</button>
                                <button class="btn btn-danger btn-sm" onclick="rejectReport(1)">Rejeter</button>
                            </td>
                        </tr>
                        <tr data-status="validated">
                            <td>Fatima Alami</td>
                            <td>Système de Recommandation</td>
                            <td>10/01/2025</td>
                            <td>Prof. Alami</td>
                            <td>Dr. Idrissi</td>
                            <td><span class="badge badge-success">Validé</span></td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="viewReport(2)">Voir</button>
                            </td>
                        </tr>
                        <tr data-status="pending">
                            <td>Youssef Idrissi</td>
                            <td>Plateforme E-learning</td>
                            <td>18/01/2025</td>
                            <td>Prof. Benjelloun</td>
                            <td>Dr. Alami</td>
                            <td><span class="badge badge-warning">En attente</span></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="validateReport(3)">Valider</button>
                                <button class="btn btn-secondary btn-sm" onclick="viewReport(3)">Voir</button>
                                <button class="btn btn-danger btn-sm" onclick="rejectReport(3)">Rejeter</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        function filterReports(status) {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                if (status === 'all') {
                    row.style.display = '';
                } else {
                    row.style.display = row.dataset.status === status ? '' : 'none';
                }
            });
        }
        
        function validateReport(id) {
            if (confirm('Valider ce rapport ?')) {
                alert('Rapport validé! Le rapporteur sera notifié.');
                // Ici vous enverriez la requête au backend
            }
        }
        
        function rejectReport(id) {
            const reason = prompt('Raison du rejet :');
            if (reason) {
                alert('Rapport rejeté. L\'étudiant sera notifié.');
                // Ici vous enverriez la requête au backend
            }
        }
        
        function viewReport(id) {
            window.open('/admin/rapports/' + id, '_blank');
        }
    </script>
</body>
</html>

