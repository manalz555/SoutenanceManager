<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants - SoutenanceManager</title>
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
            <a href="{{ url('/admin/etudiants') }}" class="active">
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 class="page-title" style="margin: 0;">👨‍🎓 Gestion des Étudiants</h2>
            <button class="btn btn-primary" onclick="openAddModal()">+ Ajouter un étudiant</button>
        </div>

        <!-- SEARCH AND FILTERS -->
        <section class="section">
            <div class="search-bar">
                <input type="text" placeholder="🔍 Rechercher un étudiant..." id="searchInput">
                <select style="padding: 12px 18px; border: 2px solid #e0e0e0; border-radius: 10px;">
                    <option>Tous les filières</option>
                    <option>Informatique</option>
                    <option>Génie Logiciel</option>
                    <option>Réseaux</option>
                </select>
                <select style="padding: 12px 18px; border: 2px solid #e0e0e0; border-radius: 10px;">
                    <option>Toutes les promotions</option>
                    <option>2024-2025</option>
                    <option>2023-2024</option>
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
                            <th>Filière</th>
                            <th>Promotion</th>
                            <th>Encadrant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Benali</td>
                            <td>Ahmed</td>
                            <td>ahmed.benali@email.com</td>
                            <td>Informatique</td>
                            <td>2024-2025</td>
                            <td>Prof. Alami</td>
                            <td><span class="badge badge-success">Actif</span></td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="editStudent(1)">Modifier</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteStudent(1)">Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Alami</td>
                            <td>Fatima</td>
                            <td>fatima.alami@email.com</td>
                            <td>Génie Logiciel</td>
                            <td>2024-2025</td>
                            <td>Prof. Zahra</td>
                            <td><span class="badge badge-success">Actif</span></td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="editStudent(2)">Modifier</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteStudent(2)">Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Idrissi</td>
                            <td>Youssef</td>
                            <td>youssef.idrissi@email.com</td>
                            <td>Réseaux</td>
                            <td>2024-2025</td>
                            <td>Prof. Benjelloun</td>
                            <td><span class="badge badge-warning">En attente</span></td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="editStudent(3)">Modifier</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteStudent(3)">Supprimer</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- MODAL AJOUT/ÉDITION -->
    <div id="studentModal" class="modal-overlay" onclick="if(event.target === this) closeModal()">
        <div class="modal-content">
            <h3 style="color: #1e3a5f; margin-bottom: 25px;" id="modalTitle">Ajouter un étudiant</h3>
            <form id="studentForm" action="{{ url('/admin/etudiants') }}" method="POST">
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
                <div class="form-row">
                    <div class="form-group">
                        <label for="filiere">Filière *</label>
                        <select id="filiere" name="filiere" required>
                            <option value="">Sélectionner...</option>
                            <option value="informatique">Informatique</option>
                            <option value="genie_logiciel">Génie Logiciel</option>
                            <option value="reseaux">Réseaux</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="promotion">Promotion *</label>
                        <select id="promotion" name="promotion" required>
                            <option value="">Sélectionner...</option>
                            <option value="2024-2025">2024-2025</option>
                            <option value="2023-2024">2023-2024</option>
                        </select>
                    </div>
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
            document.getElementById('studentModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Ajouter un étudiant';
            document.getElementById('studentForm').reset();
        }
        
        function editStudent(id) {
            document.getElementById('studentModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Modifier l\'étudiant';
            // Ici vous chargeriez les données de l'étudiant
        }
        
        function deleteStudent(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')) {
                // Ici vous enverriez la requête de suppression
                alert('Étudiant supprimé!');
            }
        }
        
        function closeModal() {
            document.getElementById('studentModal').style.display = 'none';
        }
        
        // Recherche en temps réel
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

