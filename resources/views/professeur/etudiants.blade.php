<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Étudiants - SoutenanceManager</title>
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
            <a href="{{ url('/professeur/etudiants') }}" class="active">
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 class="page-title" style="margin: 0;">👨‍🎓 Mes Étudiants</h2>
            <div class="filters">
                <button class="filter-btn active" onclick="filterByRole('all')">Tous</button>
                <button class="filter-btn" onclick="filterByRole('encadrant')">Encadrant</button>
                <button class="filter-btn" onclick="filterByRole('rapporteur')">Rapporteur</button>
                <button class="filter-btn" onclick="filterByRole('examinateur')">Examinateur</button>
                <button class="filter-btn" onclick="filterByRole('president')">Président</button>
            </div>
        </div>

        <!-- STUDENT CARDS -->
        <section class="section">
            <div class="student-grid">
                <div class="student-card" data-role="encadrant">
                    <div class="student-card-header">
                        <div class="student-name">Ahmed Benali</div>
                        <span class="badge badge-info">Encadrant</span>
                    </div>
                    <div class="student-info">📧 ahmed.benali@email.com</div>
                    <div class="student-info">🎓 Informatique - 2024-2025</div>
                    <div class="student-info">📄 Rapport: <strong>Déposé</strong></div>
                    <div class="student-info">📅 Soutenance: 28/01/2025 à 10h00</div>
                    <div class="student-actions">
                        <button class="btn btn-primary btn-sm" onclick="viewStudent(1)">Voir détails</button>
                        <button class="btn btn-success btn-sm" onclick="addFeedback(1)">Feedback</button>
                    </div>
                </div>

                <div class="student-card" data-role="rapporteur">
                    <div class="student-card-header">
                        <div class="student-name">Fatima Alami</div>
                        <span class="badge badge-warning">Rapporteur</span>
                    </div>
                    <div class="student-info">📧 fatima.alami@email.com</div>
                    <div class="student-info">🎓 Génie Logiciel - 2024-2025</div>
                    <div class="student-info">📄 Rapport: <strong>Validé</strong></div>
                    <div class="student-info">📅 Soutenance: 28/01/2025 à 14h00</div>
                    <div class="student-actions">
                        <button class="btn btn-primary btn-sm" onclick="viewStudent(2)">Voir détails</button>
                        <button class="btn btn-success btn-sm" onclick="addFeedback(2)">Feedback</button>
                    </div>
                </div>

                <div class="student-card" data-role="encadrant">
                    <div class="student-card-header">
                        <div class="student-name">Youssef Idrissi</div>
                        <span class="badge badge-info">Encadrant</span>
                    </div>
                    <div class="student-info">📧 youssef.idrissi@email.com</div>
                    <div class="student-info">🎓 Réseaux - 2024-2025</div>
                    <div class="student-info">📄 Rapport: <strong>En révision</strong></div>
                    <div class="student-info">📅 Soutenance: À planifier</div>
                    <div class="student-actions">
                        <button class="btn btn-primary btn-sm" onclick="viewStudent(3)">Voir détails</button>
                        <button class="btn btn-success btn-sm" onclick="addFeedback(3)">Feedback</button>
                    </div>
                </div>

                <div class="student-card" data-role="examinateur">
                    <div class="student-card-header">
                        <div class="student-name">Mohammed Tazi</div>
                        <span class="badge badge-info">Examinateur</span>
                    </div>
                    <div class="student-info">📧 mohammed.tazi@email.com</div>
                    <div class="student-info">🎓 Informatique - 2024-2025</div>
                    <div class="student-info">📄 Rapport: <strong>Validé</strong></div>
                    <div class="student-info">📅 Soutenance: 29/01/2025 à 11h00</div>
                    <div class="student-actions">
                        <button class="btn btn-primary btn-sm" onclick="viewStudent(4)">Voir détails</button>
                        <button class="btn btn-success btn-sm" onclick="addFeedback(4)">Feedback</button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/professeur.js') }}"></script>
    <script>
        function filterByRole(role) {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            const cards = document.querySelectorAll('.student-card');
            cards.forEach(card => {
                if (role === 'all') {
                    card.style.display = '';
                } else {
                    card.style.display = card.dataset.role === role ? '' : 'none';
                }
            });
        }
        
        function viewStudent(id) {
            window.location.href = '/professeur/etudiants/' + id;
        }
        
        function addFeedback(id) {
            window.location.href = '/professeur/feedback?etudiant=' + id;
        }
    </script>
</body>
</html>

