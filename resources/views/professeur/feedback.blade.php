<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - SoutenanceManager</title>
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
            <a href="{{ url('/professeur/feedback') }}" class="active">
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
        <h2 class="page-title">💬 Ajouter un Feedback</h2>

        <div class="alert alert-info">
            <span>ℹ️</span>
            <span>Ajoutez vos remarques et validations selon votre rôle (Encadrant, Rapporteur, Examinateur, Président).</span>
        </div>

        <!-- FORMULAIRE FEEDBACK -->
        <section class="section">
            <form action="{{ url('/professeur/feedback') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="etudiant">Étudiant *</label>
                    <select id="etudiant" name="etudiant_id" required>
                        <option value="">Sélectionner un étudiant...</option>
                        <option value="1">Ahmed Benali (Encadrant)</option>
                        <option value="2">Fatima Alami (Rapporteur)</option>
                        <option value="3">Youssef Idrissi (Encadrant)</option>
                        <option value="4">Mohammed Tazi (Examinateur)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="role">Rôle *</label>
                    <select id="role" name="role" required>
                        <option value="">Sélectionner votre rôle...</option>
                        <option value="encadrant">Encadrant</option>
                        <option value="rapporteur">Rapporteur</option>
                        <option value="examinateur">Examinateur</option>
                        <option value="president">Président</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type">Type de feedback *</label>
                    <select id="type" name="type" required>
                        <option value="">Sélectionner...</option>
                        <option value="remarque">Remarque</option>
                        <option value="validation">Validation</option>
                        <option value="rejet">Rejet</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sujet">Sujet *</label>
                    <input type="text" id="sujet" name="sujet" placeholder="Ex: Références bibliographiques" required>
                </div>

                <div class="form-group">
                    <label for="contenu">Contenu du feedback *</label>
                    <textarea id="contenu" name="contenu" placeholder="Décrivez vos remarques ou validations..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="pages">Pages concernées (optionnel)</label>
                    <input type="text" id="pages" name="pages" placeholder="Ex: 15-20, 35">
                </div>

                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">Enregistrer le feedback</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.reload()">Annuler</button>
                </div>
            </form>
        </section>

        <!-- HISTORIQUE DES FEEDBACKS -->
        <section class="section">
            <h3 class="section-title">📝 Historique de mes feedbacks</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Étudiant</th>
                            <th>Rôle</th>
                            <th>Sujet</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>10/01/2025</td>
                            <td>Ahmed Benali</td>
                            <td><span class="badge badge-info">Encadrant</span></td>
                            <td>Références bibliographiques</td>
                            <td><span class="badge badge-warning">Remarque</span></td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="viewFeedback(1)">Voir</button>
                            </td>
                        </tr>
                        <tr>
                            <td>08/01/2025</td>
                            <td>Fatima Alami</td>
                            <td><span class="badge badge-warning">Rapporteur</span></td>
                            <td>Validation du rapport</td>
                            <td><span class="badge badge-success">Validation</span></td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="viewFeedback(2)">Voir</button>
                            </td>
                        </tr>
                        <tr>
                            <td>05/01/2025</td>
                            <td>Youssef Idrissi</td>
                            <td><span class="badge badge-info">Encadrant</span></td>
                            <td>Méthodologie</td>
                            <td><span class="badge badge-warning">Remarque</span></td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="viewFeedback(3)">Voir</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/professeur.js') }}"></script>
    <script>
        function viewFeedback(id) {
            alert('Détails du feedback ' + id);
            // Ici vous ouvririez un modal avec les détails
        }
    </script>
</body>
</html>

