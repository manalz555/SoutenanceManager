@extends('etudiant.layout')

@section('title', 'Dashboard')

@section('content')
    <h2 class="page-title">Bienvenue, {{ $etudiant->full_name }} !</h2>

    @php $nouvelles = $etudiant->remarques->where('statut', 'nouvelle')->count(); @endphp

    <div class="cards-container">
        <div class="stat-card blue"><h3>{{ $etudiant->documents->count() }}</h3><p>Documents déposés</p></div>
        <div class="stat-card green"><h3>{{ $rapport ? $rapport->statut_libelle : 'Non déposé' }}</h3><p>Statut du rapport</p></div>
        <div class="stat-card orange"><h3>{{ $nouvelles }}</h3><p>Remarques à traiter</p></div>
        <div class="stat-card purple"><h3>{{ $joursAvant !== null ? $joursAvant.' j' : '—' }}</h3><p>Avant soutenance</p></div>
    </div>

    @if ($soutenance)
        <div class="alert alert-info">
            <span>Votre soutenance est prévue le <strong>{{ $soutenance->Date_Sout->translatedFormat('d F Y \à H\hi') }}</strong> en salle <strong>{{ $soutenance->Salle_Sout }}</strong>.</span>
        </div>
    @else
        <div class="alert alert-warning">
            <span>Votre soutenance n'est pas encore planifiée. Déposez votre rapport pour que l'administration puisse la programmer.</span>
        </div>
    @endif

    <section class="section">
        <h3 class="section-title">État de mon parcours</h3>
        <div class="info-grid">
            <div class="info-item"><div class="info-label">Dossier de stage</div><div class="info-value">{{ $dossier ? $dossier->statut_libelle : 'Non déposé' }}</div></div>
            <div class="info-item"><div class="info-label">Rapport final</div><div class="info-value">{{ $rapport ? $rapport->statut_libelle : 'Non déposé' }}</div></div>
            <div class="info-item"><div class="info-label">Encadrant</div><div class="info-value">{{ $etudiant->encadrant?->full_name ?? 'Non assigné' }}</div></div>
            <div class="info-item"><div class="info-label">Rapporteur</div><div class="info-value">{{ $etudiant->rapporteur?->full_name ?? 'Non assigné' }}</div></div>
            <div class="info-item"><div class="info-label">Jury</div><div class="info-value">{{ $soutenance ? $soutenance->juryMembers->count().' membres' : 'Non constitué' }}</div></div>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">Dernières remarques</h3>
        @forelse ($etudiant->remarques->take(3) as $r)
            <div class="remark-item">
                <div class="remark-header">
                    <span class="remark-author">{{ $r->professeur->full_name }}</span>
                    <span class="remark-date">{{ $r->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="remark-content">@if ($r->sujet)<strong>{{ $r->sujet }}</strong> — @endif{{ $r->contenu }}</div>
            </div>
        @empty
            <p class="empty">Aucune remarque pour le moment.</p>
        @endforelse
        <a href="{{ route('etudiant.remarques') }}" class="btn btn-primary">Voir toutes les remarques</a>
    </section>

    @if ($soutenance)
        <section class="section">
            <h3 class="section-title">Informations de ma soutenance</h3>
            <div class="info-grid">
                <div class="info-item"><div class="info-label">Date</div><div class="info-value">{{ $soutenance->Date_Sout->translatedFormat('d F Y') }}</div></div>
                <div class="info-item"><div class="info-label">Heure</div><div class="info-value">{{ $soutenance->Date_Sout->format('H\hi') }}</div></div>
                <div class="info-item"><div class="info-label">Salle</div><div class="info-value">{{ $soutenance->Salle_Sout }}</div></div>
                <div class="info-item"><div class="info-label">Note finale</div><div class="info-value">{{ $soutenance->Note_finale !== null ? number_format($soutenance->Note_finale, 2).' / 20' : 'En attente' }}</div></div>
            </div>
            <a href="{{ route('etudiant.soutenance') }}" class="btn btn-primary" style="margin-top: 20px;">Voir les détails complets</a>
        </section>
    @endif
@endsection
