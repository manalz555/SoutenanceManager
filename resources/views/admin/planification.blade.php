<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planification des Soutenances - SoutenanceManager</title>
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
            <a href="{{ url('/admin/planification') }}" class="active">
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
        <h2 class="page-title">📅 Planification des Soutenances</h2>

        <div class="alert alert-info">
            <span>ℹ️</span>
            <span>Planifiez les dates, heures et salles pour les soutenances. Le jury doit être complet.</span>
        </div>

        <!-- TABLE -->
        <section class="section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Jury</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Salle</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Ahmed Benali</strong></td>
                            <td>4 membres ✓</td>
                            <td>
                                <input type="date" value="2025-01-28" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                            </td>
                            <td>
                                <input type="time" value="10:00" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                            </td>
                            <td>
                                <select style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                                    <option>B102</option>
                                    <option>B103</option>
                                    <option>A201</option>
                                    <option>A202</option>
                                </select>
                            </td>
                            <td><span class="badge badge-success">Planifiée</span></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="savePlanning(1)">Enregistrer</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Fatima Alami</strong></td>
                            <td>4 membres ✓</td>
                            <td>
                                <input type="date" value="2025-01-28" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                            </td>
                            <td>
                                <input type="time" value="14:00" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                            </td>
                            <td>
                                <select style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                                    <option>B103</option>
                                    <option>B102</option>
                                    <option>A201</option>
                                </select>
                            </td>
                            <td><span class="badge badge-success">Planifiée</span></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="savePlanning(2)">Enregistrer</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Youssef Idrissi</strong></td>
                            <td>4 membres ✓</td>
                            <td>
                                <input type="date" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                            </td>
                            <td>
                                <input type="time" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                            </td>
                            <td>
                                <select style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                                    <option value="">Sélectionner...</option>
                                    <option>A201</option>
                                    <option>A202</option>
                                    <option>B102</option>
                                </select>
                            </td>
                            <td><span class="badge badge-warning">À planifier</span></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="savePlanning(3)">Enregistrer</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        function savePlanning(id) {
            alert('Planification enregistrée! L\'étudiant et le jury seront notifiés.');
            // Ici vous enverriez la requête au backend
        }
    </script>
</body>
</html>

