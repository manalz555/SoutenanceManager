<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignations - SoutenanceManager</title>
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
            <a href="{{ url('/admin/assignations') }}" class="active">
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
        <h2 class="page-title">🔗 Assignation des Encadrants et Rapporteurs</h2>

        <div class="alert alert-info">
            <span>ℹ️</span>
            <span>Assignez un encadrant et un rapporteur à chaque étudiant pour le suivi de son stage.</span>
        </div>

        <!-- TABLE -->
        <section class="section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Filière</th>
                            <th>Encadrant</th>
                            <th>Rapporteur</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ahmed Benali</td>
                            <td>Informatique</td>
                            <td>
                                <select class="form-group" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                                    <option>Prof. Zahra</option>
                                    <option>Prof. Alami</option>
                                    <option>Prof. Benjelloun</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-group" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                                    <option>Dr. Alami</option>
                                    <option>Dr. Idrissi</option>
                                </select>
                            </td>
                            <td><span class="badge badge-success">Assigné</span></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="saveAssignment(1)">Enregistrer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Fatima Alami</td>
                            <td>Génie Logiciel</td>
                            <td>
                                <select class="form-group" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                                    <option value="">Sélectionner...</option>
                                    <option>Prof. Zahra</option>
                                    <option>Prof. Alami</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-group" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                                    <option value="">Sélectionner...</option>
                                    <option>Dr. Alami</option>
                                    <option>Dr. Idrissi</option>
                                </select>
                            </td>
                            <td><span class="badge badge-warning">En attente</span></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="saveAssignment(2)">Enregistrer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Youssef Idrissi</td>
                            <td>Réseaux</td>
                            <td>
                                <select class="form-group" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                                    <option>Prof. Benjelloun</option>
                                    <option>Prof. Zahra</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-group" style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px;">
                                    <option>Dr. Idrissi</option>
                                    <option>Dr. Alami</option>
                                </select>
                            </td>
                            <td><span class="badge badge-success">Assigné</span></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="saveAssignment(3)">Enregistrer</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        function saveAssignment(id) {
            alert('Assignation enregistrée avec succès!');
            // Ici vous enverriez la requête au backend
        }
    </script>
</body>
</html>

