<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning Global - SoutenanceManager</title>
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
            <a href="{{ url('/admin/planning') }}" class="active">
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 class="page-title" style="margin: 0;">📋 Planning Global des Soutenances</h2>
            <div style="display: flex; gap: 10px;">
                <select id="filterDate" style="padding: 12px 18px; border: 2px solid #e0e0e0; border-radius: 10px;">
                    <option value="">Toutes les dates</option>
                    <option value="2025-01-28">28 Janvier 2025</option>
                    <option value="2025-01-29">29 Janvier 2025</option>
                    <option value="2025-01-30">30 Janvier 2025</option>
                </select>
                <select id="filterFiliere" style="padding: 12px 18px; border: 2px solid #e0e0e0; border-radius: 10px;">
                    <option value="">Toutes les filières</option>
                    <option value="informatique">Informatique</option>
                    <option value="genie_logiciel">Génie Logiciel</option>
                    <option value="reseaux">Réseaux</option>
                </select>
                <select id="filterEncadrant" style="padding: 12px 18px; border: 2px solid #e0e0e0; border-radius: 10px;">
                    <option value="">Tous les encadrants</option>
                    <option value="zahra">Prof. Zahra</option>
                    <option value="alami">Prof. Alami</option>
                    <option value="benjelloun">Prof. Benjelloun</option>
                </select>
            </div>
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
                            <th>Filière</th>
                            <th>Encadrant</th>
                            <th>Jury</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-date="2025-01-28" data-filiere="informatique" data-encadrant="zahra">
                            <td>28/01/2025</td>
                            <td>10h00</td>
                            <td>B102</td>
                            <td><strong>Ahmed Benali</strong></td>
                            <td>Informatique</td>
                            <td>Prof. Zahra</td>
                            <td>4 membres</td>
                            <td><span class="badge badge-success">Confirmée</span></td>
                        </tr>
                        <tr data-date="2025-01-28" data-filiere="genie_logiciel" data-encadrant="alami">
                            <td>28/01/2025</td>
                            <td>14h00</td>
                            <td>B103</td>
                            <td><strong>Fatima Alami</strong></td>
                            <td>Génie Logiciel</td>
                            <td>Prof. Alami</td>
                            <td>4 membres</td>
                            <td><span class="badge badge-success">Confirmée</span></td>
                        </tr>
                        <tr data-date="2025-01-29" data-filiere="reseaux" data-encadrant="benjelloun">
                            <td>29/01/2025</td>
                            <td>09h00</td>
                            <td>A201</td>
                            <td><strong>Youssef Idrissi</strong></td>
                            <td>Réseaux</td>
                            <td>Prof. Benjelloun</td>
                            <td>4 membres</td>
                            <td><span class="badge badge-warning">En attente</span></td>
                        </tr>
                        <tr data-date="2025-01-29" data-filiere="informatique" data-encadrant="zahra">
                            <td>29/01/2025</td>
                            <td>11h00</td>
                            <td>A202</td>
                            <td><strong>Mohammed Tazi</strong></td>
                            <td>Informatique</td>
                            <td>Prof. Zahra</td>
                            <td>4 membres</td>
                            <td><span class="badge badge-success">Confirmée</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        document.getElementById('filterDate').addEventListener('change', filterTable);
        document.getElementById('filterFiliere').addEventListener('change', filterTable);
        document.getElementById('filterEncadrant').addEventListener('change', filterTable);
        
        function filterTable() {
            const dateFilter = document.getElementById('filterDate').value;
            const filiereFilter = document.getElementById('filterFiliere').value;
            const encadrantFilter = document.getElementById('filterEncadrant').value;
            
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const date = row.dataset.date || '';
                const filiere = row.dataset.filiere || '';
                const encadrant = row.dataset.encadrant || '';
                
                const showRow = 
                    (!dateFilter || date === dateFilter) &&
                    (!filiereFilter || filiere === filiereFilter) &&
                    (!encadrantFilter || encadrant === encadrantFilter);
                
                row.style.display = showRow ? '' : 'none';
            });
        }
    </script>
</body>
</html>

