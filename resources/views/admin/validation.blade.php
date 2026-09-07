@extends('layouts.admin')

@section('title', 'Validation des Rapports')

@section('content')
    <h2 class="page-title">✓ Validation des Rapports</h2>

    <div class="filters">
        <button class="filter-btn active" onclick="filterReports('all', this)">Tous</button>
        <button class="filter-btn" onclick="filterReports('soumis', this)">En attente</button>
        <button class="filter-btn" onclick="filterReports('valide', this)">Validés</button>
        <button class="filter-btn" onclick="filterReports('rejete', this)">Rejetés</button>
    </div>

    <section class="section">
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>Étudiant</th><th>Document</th><th>Type</th><th>Date dépôt</th><th>Encadrant</th><th>Rapporteur</th><th>Statut</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($documents as $doc)
                        <tr data-status="{{ $doc->statut }}">
                            <td>{{ $doc->etudiant->full_name }}</td>
                            <td>{{ $doc->titre }}<br><span class="muted">{{ $doc->nom_fichier_original }} · {{ $doc->taille_formatee }}</span></td>
                            <td>{{ $doc->type_libelle }}</td>
                            <td>{{ $doc->date_soumission->format('d/m/Y') }}</td>
                            <td>{{ $doc->etudiant->encadrant?->full_name ?? '—' }}</td>
                            <td>{{ $doc->etudiant->rapporteur?->full_name ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $doc->statut_badge }}">{{ $doc->statut_libelle }}</span>
                                @if ($doc->statut === 'rejete' && $doc->commentaire)
                                    <br><span class="muted">{{ $doc->commentaire }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($doc->statut !== 'valide')
                                    <form class="inline-form" method="POST" action="{{ route('admin.documents.valider', $doc->id) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Valider</button>
                                    </form>
                                @endif
                                @if ($doc->statut !== 'rejete')
                                    <form class="inline-form" method="POST" action="{{ route('admin.documents.rejeter', $doc->id) }}" onsubmit="return rejeter(this)">
                                        @csrf
                                        <input type="hidden" name="commentaire">
                                        <button class="btn btn-danger btn-sm">Rejeter</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="empty">Aucun document déposé pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function filterReports(status, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('tbody tr[data-status]').forEach(row => {
            row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
        });
    }
    function rejeter(form) {
        const motif = prompt('Motif du rejet (optionnel) :');
        if (motif === null) return false;
        form.querySelector('input[name=commentaire]').value = motif;
        return true;
    }
</script>
@endsection
