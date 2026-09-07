@extends('etudiant.layout')

@section('title', 'Dépôt de documents')

@section('content')
    <h2 class="page-title">Dépôt de mes documents</h2>

    <div class="alert alert-info">
        <span>Formats acceptés : PDF uniquement. Taille maximale : 10 Mo.</span>
    </div>

    <section class="section">
        <h3 class="section-title">Déposer un document</h3>
        <form method="POST" action="{{ route('etudiant.depot') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="type">Type de document *</label>
                <select id="type" name="type" required onchange="toggleEntreprise(this.value)">
                    @foreach (\App\Models\Document::TYPES as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', 'rapport') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="titre">Titre *</label>
                <input type="text" id="titre" name="titre" value="{{ old('titre') }}" placeholder="Ex : Développement d'une application web" required>
            </div>
            <div class="form-group" id="entreprise-group">
                <label for="entreprise">Entreprise d'accueil</label>
                <input type="text" id="entreprise" name="entreprise" value="{{ old('entreprise') }}" placeholder="Ex : TechCorp Maroc">
            </div>
            <div class="form-group">
                <label for="document">Fichier PDF *</label>
                <div class="file-upload-wrapper">
                    <label for="document" class="file-upload-label">Choisir le fichier</label>
                    <input type="file" id="document" name="document" accept=".pdf" required onchange="showFileName(this, 'file-name')">
                </div>
                <div id="file-name" class="file-name"></div>
            </div>
            <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" id="est_version_corrigee" name="est_version_corrigee" value="1" style="width: auto;" @checked(old('est_version_corrigee'))>
                <label for="est_version_corrigee" style="margin: 0;">Il s'agit d'une version corrigée (après remarques)</label>
            </div>
            <button type="submit" class="btn btn-success">Déposer le document</button>
        </form>
    </section>

    <section class="section">
        <h3 class="section-title">Mes documents</h3>
        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead><tr><th>Type</th><th>Titre</th><th>Fichier</th><th>Déposé le</th><th>Statut</th></tr></thead>
                <tbody>
                    @forelse ($documents as $doc)
                        <tr>
                            <td>{{ $doc->type_libelle }}@if ($doc->est_version_corrigee) <span class="muted">(corrigée)</span>@endif</td>
                            <td>{{ $doc->titre }}</td>
                            <td>{{ $doc->nom_fichier_original }} <span class="muted">({{ $doc->taille_formatee }})</span></td>
                            <td>{{ $doc->date_soumission->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge {{ $doc->statut_badge }}">{{ $doc->statut_libelle }}</span>
                                @if ($doc->statut === 'rejete' && $doc->commentaire)
                                    <br><span class="muted">{{ $doc->commentaire }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty">Vous n'avez encore déposé aucun document.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function toggleEntreprise(type) {
        document.getElementById('entreprise-group').style.display = type === 'dossier_stage' ? '' : 'none';
    }
    function showFileName(input, targetId) {
        const target = document.getElementById(targetId);
        target.textContent = input.files.length ? '📄 ' + input.files[0].name : '';
    }
    toggleEntreprise(document.getElementById('type').value);
</script>
@endsection
