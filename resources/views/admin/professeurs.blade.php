@extends('layouts.admin')

@section('title', 'Gestion des Professeurs')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 class="page-title" style="margin: 0;">👨‍🏫 Gestion des Professeurs</h2>
        <button class="btn btn-primary" onclick="openAddModal()">+ Ajouter un professeur</button>
    </div>

    <section class="section">
        <div class="search-bar">
            <input type="text" placeholder="🔍 Rechercher un professeur..." id="searchInput">
        </div>
    </section>

    <section class="section">
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Rôle principal</th><th>Étudiants encadrés</th><th>Rapports à évaluer</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $t)
                        <tr>
                            <td>{{ $t->nom_prof }}</td>
                            <td>{{ $t->prenom_prof }}</td>
                            <td>{{ $t->email_prof }}</td>
                            <td><span class="badge badge-info">{{ $t->role_libelle }}</span></td>
                            <td>{{ $t->etudiants_encadres_count }}</td>
                            <td>{{ $t->etudiants_rapportes_count }}</td>
                            <td>
                                <form class="inline-form" method="POST" action="{{ route('admin.teachers.destroy', $t->id) }}" onsubmit="return confirm('Supprimer ce professeur ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="empty">Aucun professeur enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div id="professorModal" class="modal-overlay" style="{{ $errors->any() ? 'display:flex' : '' }}" onclick="if(event.target === this) closeModal()">
        <div class="modal-content">
            <h3 style="color: #1e3a5f; margin-bottom: 25px;">Ajouter un professeur</h3>
            <form method="POST" action="{{ route('admin.teachers.store') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group"><label for="nom_prof">Nom *</label><input type="text" id="nom_prof" name="nom_prof" value="{{ old('nom_prof') }}" required></div>
                    <div class="form-group"><label for="prenom_prof">Prénom *</label><input type="text" id="prenom_prof" name="prenom_prof" value="{{ old('prenom_prof') }}" required></div>
                </div>
                <div class="form-group"><label for="email_prof">Email *</label><input type="email" id="email_prof" name="email_prof" value="{{ old('email_prof') }}" required></div>
                <div class="form-group">
                    <label for="role_prof">Rôle principal *</label>
                    <select id="role_prof" name="role_prof" required>
                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}" @selected(old('role_prof') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group"><label for="password_prof">Mot de passe *</label><input type="password" id="password_prof" name="password_prof" required minlength="6"></div>
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
    function openAddModal() { document.getElementById('professorModal').style.display = 'flex'; }
    function closeModal() { document.getElementById('professorModal').style.display = 'none'; }
    document.getElementById('searchInput').addEventListener('input', function (e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });
</script>
@endsection
