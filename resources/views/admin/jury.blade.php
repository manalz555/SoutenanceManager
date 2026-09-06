<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formation du Jury - SoutenanceManager</title>
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
            <a href="{{ url('/admin/jury') }}" class="active">
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
        <h2 class="page-title">👥 Formation du Jury</h2>

        <div class="alert alert-info">
            <span>ℹ️</span>
            <span>Après validation du rapport, formez le jury complet (Encadrant, Rapporteur, Examinateur, Président).</span>
        </div>

        <!-- TABLE -->
        <section class="section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Encadrant</th>
                            <th>Rapporteur</th>
                            <th>Examinateur</th>
                            <th>Président</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Ahmed Benali</strong></td>
                            <td>Prof. Zahra ✓</td>
                            <td>Dr. Alami ✓</td>
                            <td>
                                <select style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px; width: 100%;">
                                    <option value="">Sélectionner...</option>
                                    <option>Dr. Idrissi</option>
                                    <option>Dr. Bennani</option>
                                </select>
                            </td>
                            <td>
                                <select style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px; width: 100%;">
                                    <option value="">Sélectionner...</option>
                                    <option>Prof. Benjelloun</option>
                                    <option>Prof. Tazi</option>
                                </select>
                            </td>
                            <td><span class="badge badge-warning">En cours</span></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="saveJury(1)">Enregistrer</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Fatima Alami</strong></td>
                            <td>Prof. Alami ✓</td>
                            <td>Dr. Idrissi ✓</td>
                            <td>Dr. Bennani ✓</td>
                            <td>Prof. Benjelloun ✓</td>
                            <td><span class="badge badge-success">Complet</span></td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="viewJury(2)">Voir</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Youssef Idrissi</strong></td>
                            <td>Prof. Benjelloun ✓</td>
                            <td>Dr. Alami ✓</td>
                            <td>
                                <select style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px; width: 100%;">
                                    <option value="">Sélectionner...</option>
                                    <option>Dr. Idrissi</option>
                                    <option>Dr. Bennani</option>
                                </select>
                            </td>
                            <td>
                                <select style="padding: 8px; border: 1px solid #e0e0e0; border-radius: 5px; width: 100%;">
                                    <option value="">Sélectionner...</option>
                                    <option>Prof. Benjelloun</option>
                                    <option>Prof. Tazi</option>
                                </select>
                            </td>
                            <td><span class="badge badge-warning">En cours</span></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="saveJury(3)">Enregistrer</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        function saveJury(id) {
            alert('Jury enregistré avec succès!');
            // Ici vous enverriez la requête au backend
        }
        
        function viewJury(id) {
            alert('Détails du jury pour l\'étudiant ' + id);
        }
    </script>
</body>
</html>

