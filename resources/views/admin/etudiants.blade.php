@extends('layouts.admin')

@section('title', 'Gestion des Étudiants')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 class="page-title" style="margin: 0;">👨‍🎓 Gestion des Étudiants</h2>
        <button class="btn btn-primary" onclick="openAddModal()">+ Ajouter un étudiant</button>
    </div>

    <section class="section">
        <div class="search-bar">
            <input type="text" placeholder="🔍 Rechercher un étudiant..." id="searchInput">
        </div>
    </section>

    <section class="section">
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Matricule</th><th>Filière</th><th>Promotion</th><th>Encadrant</th><th>Soutenance</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($students as $s)
                        <tr>
                            <td>{{ $s->nom }}</td>
                            <td>{{ $s->prenom }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->matricule ?? '—' }}</td>
                            <td>{{ $s->filiere ?? '—' }}</td>
                            <td>{{ $s->annee_universitaire ?? '—' }}</td>
                            <td>{{ $s->encadrant?->full_name ?? '—' }}</td>
                            <td>
                                @if ($s->soutenance)
                                    <span class="badge badge-success">{{ $s->soutenance->Date_Sout->format('d/m/Y') }}</span>
                                @else
                                    <span class="badge badge-warning">À planifier</span>
                                @endif
                            </td>
                            <td>
                                <form class="inline-form" method="POST" action="{{ route('admin.students.destroy', $s->id) }}" onsubmit="return confirm('Supprimer cet étudiant ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="empty">Aucun étudiant enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div id="studentModal" class="modal-overlay" style="{{ $errors->any() ? 'display:flex' : '' }}" onclick="if(event.target === this) closeModal()">
        <div class="modal-content">
            <h3 style="color: #1e3a5f; margin-bottom: 25px;">Ajouter un étudiant</h3>
            <form method="POST" action="{{ route('admin.students.store') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group"><label for="nom">Nom *</label><input type="text" id="nom" name="nom" value="{{ old('nom') }}" required></div>
                    <div class="form-group"><label for="prenom">Prénom *</label><input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required></div>
                </div>
                <div class="form-group"><label for="email">Email *</label><input type="email" id="email" name="email" value="{{ old('email') }}" required></div>
                <div class="form-row">
                    <div class="form-group"><label for="matricule">Matricule</label><input type="text" id="matricule" name="matricule" value="{{ old('matricule') }}"></div>
                    <div class="form-group"><label for="date_naissance">Date de naissance</label><input type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}"></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label for="filiere">Filière</label><input type="text" id="filiere" name="filiere" value="{{ old('filiere') }}" placeholder="Informatique"></div>
                    <div class="form-group"><label for="annee_universitaire">Promotion</label><input type="text" id="annee_universitaire" name="annee_universitaire" value="{{ old('annee_universitaire') }}" placeholder="2024-2025"></div>
                </div>
                <div class="form-group"><label for="password">Mot de passe *</label><input type="password" id="password" name="password" required minlength="6"></div>
                <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 30px;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openAddModal() { document.getElementById('studentModal').style.display = 'flex'; }
    function closeModal() { document.getElementById('studentModal').style.display = 'none'; }
    document.getElementById('searchInput').addEventListener('input', function (e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });
</script>
@endsection
