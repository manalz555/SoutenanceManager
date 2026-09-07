@extends('layouts.professeur')

@section('title', $etudiant->full_name)

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 class="page-title" style="margin: 0;">👨‍🎓 {{ $etudiant->full_name }}</h2>
        <span class="badge badge-info">Mon rôle : {{ \App\Models\professeurs::ROLES[$monRole] ?? ucfirst($monRole) }}</span>
    </div>

    <section class="section">
        <h3 class="section-title">ℹ️ Informations</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; color: #444;">
            <div>📧 {{ $etudiant->email }}</div>
            <div>🎓 {{ $etudiant->filiere ?? '—' }} · {{ $etudiant->annee_universitaire ?? '—' }}</div>
            <div>🆔 {{ $etudiant->matricule ?? '—' }}</div>
            <div>👨‍🏫 Encadrant : {{ $etudiant->encadrant?->full_name ?? '—' }}</div>
            <div>📝 Rapporteur : {{ $etudiant->rapporteur?->full_name ?? '—' }}</div>
            <div>📅 Soutenance : {{ $etudiant->soutenance ? $etudiant->soutenance->Date_Sout->format('d/m/Y \à H\hi').' — '.$etudiant->soutenance->Salle_Sout : 'À planifier' }}</div>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">📄 Documents déposés</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Type</th><th>Titre</th><th>Déposé le</th><th>Taille</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($etudiant->documents as $doc)
                        <tr>
                            <td>{{ $doc->type_libelle }}@if ($doc->est_version_corrigee) <span class="muted">(corrigée)</span>@endif</td>
                            <td>{{ $doc->titre }}</td>
                            <td>{{ $doc->date_soumission->format('d/m/Y') }}</td>
                            <td>{{ $doc->taille_formatee }}</td>
                            <td><span class="badge {{ $doc->statut_badge }}">{{ $doc->statut_libelle }}</span></td>
                            <td>
                                <a href="{{ route('professor.documents.show', [$etudiant->id, $doc->id]) }}" class="btn btn-primary btn-sm">Télécharger</a>
                                @if (in_array($monRole, ['encadrant', 'rapporteur']) && $doc->statut !== 'valide')
                                    <form class="inline-form" method="POST" action="{{ route('professor.documents.valider', $doc->id) }}">
                                        @csrf <input type="hidden" name="statut" value="valide">
                                        <button class="btn btn-success btn-sm">Valider</button>
                                    </form>
                                @endif
                                @if (in_array($monRole, ['encadrant', 'rapporteur']) && $doc->statut !== 'rejete')
                                    <form class="inline-form" method="POST" action="{{ route('professor.documents.valider', $doc->id) }}">
                                        @csrf <input type="hidden" name="statut" value="rejete">
                                        <button class="btn btn-danger btn-sm">Rejeter</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty">Aucun document déposé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="section" id="remarque">
        <h3 class="section-title">💬 Ajouter une remarque</h3>
        <form method="POST" action="{{ route('professor.remarques.store', $etudiant->id) }}">
            @csrf
            <div class="form-group">
                <label for="document_id">Document concerné</label>
                <select id="document_id" name="document_id">
                    <option value="">— Remarque générale —</option>
                    @foreach ($etudiant->documents as $doc)
                        <option value="{{ $doc->id }}" @selected(old('document_id') == $doc->id)>{{ $doc->type_libelle }} — {{ $doc->titre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="sujet">Sujet</label>
                <input type="text" id="sujet" name="sujet" value="{{ old('sujet') }}" placeholder="Ex : Références bibliographiques">
            </div>
            <div class="form-group">
                <label for="contenu">Contenu *</label>
                <textarea id="contenu" name="contenu" required placeholder="Décrivez vos remarques...">{{ old('contenu') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer la remarque</button>
        </form>
    </section>

    <section class="section">
        <h3 class="section-title">📝 Historique des remarques</h3>
        @forelse ($etudiant->remarques as $r)
            <div style="border-left: 4px solid {{ $r->estTraitee() ? '#4caf50' : '#ff9800' }}; background: {{ $r->estTraitee() ? '#f0fdf4' : '#fff8ee' }}; padding: 15px 20px; border-radius: 8px; margin-bottom: 12px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <strong style="color: #1e3a5f;">{{ $r->sujet ?? 'Remarque' }}</strong>
                    <span class="muted">{{ $r->professeur->full_name }} · {{ $r->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div style="color: #444;">{{ $r->contenu }}</div>
                <div class="muted" style="margin-top: 6px;">
                    {{ $r->estTraitee() ? 'Traitée par l\'étudiant le '.$r->date_resolution->format('d/m/Y') : 'En attente de traitement' }}
                </div>
            </div>
        @empty
            <p class="empty">Aucune remarque pour cet étudiant.</p>
        @endforelse
    </section>

    <a href="{{ route('professor.etudiants') }}" class="btn btn-secondary">← Retour à mes étudiants</a>
@endsection
