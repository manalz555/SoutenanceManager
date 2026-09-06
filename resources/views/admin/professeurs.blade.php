<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Professeurs - SoutenanceManager</title>
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
            <a href="{{ url('/admin/professeurs') }}" class="active">
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 class="page-title" style="margin: 0;">👨‍🏫 Gestion des Professeurs</h2>
            <button class="btn btn-primary" onclick="openAddModal()">+ Ajouter un professeur</button>
        </div>

        <!-- SEARCH -->
        <section class="section">
            <div class="search-bar">
                <input type="text" placeholder="🔍 Rechercher un professeur..." id="searchInput">
                <select style="padding: 12px 18px; border: 2px solid #e0e0e0; border-radius: 10px;">
                    <option>Tous les rôles</option>
                    <option>Encadrant</option>
                    <option>Rapporteur</option>
                    <option>Examinateur</option>
                    <option>Président</option>
                </select>
            </div>
        </section>

        <!-- TABLE -->
        <section class="section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Étudiants encadrés</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Alami</td>
                            <td>Mohammed</td>
                            <td>m.alami@univ.edu</td>
                            <td><span class="badge badge-info">Rapporteur</span></td>
                            <td>5</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="editProfessor(1)">Modifier</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteProfessor(1)">Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Zahra</td>
                            <td>Fatima</td>
                            <td>f.zahra@univ.edu</td>
                            <td><span class="badge badge-success">Encadrant</span></td>
                            <td>8</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="editProfessor(2)">Modifier</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteProfessor(2)">Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Benjelloun</td>
                            <td>Ahmed</td>
                            <td>a.benjelloun@univ.edu</td>
                            <td><span class="badge badge-warning">Président</span></td>
                            <td>3</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="editProfessor(3)">Modifier</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteProfessor(3)">Supprimer</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- MODAL -->
    <div id="professorModal" class="modal-overlay" onclick="if(event.target === this) closeModal()">
        <div class="modal-content">
            <h3 style="color: #1e3a5f; margin-bottom: 25px;" id="modalTitle">Ajouter un professeur</h3>
            <form id="professorForm" action="{{ url('/admin/professeurs') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="role">Rôle *</label>
                    <select id="role" name="role" required>
                        <option value="">Sélectionner...</option>
                        <option value="encadrant">Encadrant</option>
                        <option value="rapporteur">Rapporteur</option>
                        <option value="examinateur">Examinateur</option>
                        <option value="president">Président</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe *</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 30px;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        function openAddModal() {
            document.getElementById('professorModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Ajouter un professeur';
            document.getElementById('professorForm').reset();
        }
        
        function editProfessor(id) {
            document.getElementById('professorModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Modifier le professeur';
        }
        
        function deleteProfessor(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')) {
                alert('Professeur supprimé!');
            }
        }
        
        function closeModal() {
            document.getElementById('professorModal').style.display = 'none';
        }
        
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html>

