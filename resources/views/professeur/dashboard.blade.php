@extends('layouts.professeur')

@section('title', 'Dashboard Professeur')

@section('content')
    <h2 class="page-title">📊 Bienvenue, {{ $professeur->full_name }}</h2>

    <div class="cards-container">
        <div class="stat-card blue"><div class="stat-icon">👨‍🎓</div><h3>{{ $stats['etudiants'] }}</h3><p>Étudiants suivis</p></div>
        <div class="stat-card green"><div class="stat-icon">📄</div><h3>{{ $stats['rapports'] }}</h3><p>Rapports reçus</p></div>
        <div class="stat-card orange"><div class="stat-icon">💬</div><h3>{{ $stats['remarques'] }}</h3><p>Remarques données</p></div>
        <div class="stat-card purple"><div class="stat-icon">📅</div><h3>{{ $stats['soutenances'] }}</h3><p>Soutenances à venir</p></div>
    </div>

    <section class="section">
        <h3 class="section-title">🎭 Mes rôles</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            @foreach ([['encadrant', '👨‍🏫', 'Encadrant', '#4db8ff', 'étudiants'], ['rapporteur', '📝', 'Rapporteur', '#ff9800', 'étudiants'], ['examinateur', '🔍', 'Examinateur', '#9c27b0', 'jurys'], ['president', '👑', 'Président', '#ffd700', 'jurys']] as [$key, $icon, $label, $color, $unit])
                <div style="background: #f7f9fc; padding: 20px; border-radius: 10px; border-left: 4px solid {{ $color }}; text-align: center;">
                    <div style="font-size: 32px; margin-bottom: 10px;">{{ $icon }}</div>
                    <div style="font-weight: 600; color: #1e3a5f; margin-bottom: 5px;">{{ $label }}</div>
                    <div style="color: #666; font-size: 14px;">{{ $roles[$key] }} {{ $unit }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">📄 Documents récemment reçus</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Étudiant</th><th>Titre</th><th>Type</th><th>Date réception</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($documentsRecents as $doc)
                        <tr>
                            <td>{{ $doc->etudiant->full_name }}</td>
                            <td>{{ $doc->titre }}</td>
                            <td>{{ $doc->type_libelle }}</td>
                            <td>{{ $doc->date_soumission->format('d/m/Y') }}</td>
                            <td><span class="badge {{ $doc->statut_badge }}">{{ $doc->statut_libelle }}</span></td>
                            <td><a href="{{ route('professor.etudiant.show', $doc->etudiant_id) }}" class="btn btn-primary btn-sm">Voir</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty">Aucun document reçu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">📅 Prochaines soutenances</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Date</th><th>Heure</th><th>Salle</th><th>Étudiant</th><th>Mon rôle</th></tr></thead>
                <tbody>
                    @forelse ($soutenancesAvenir as $s)
                        <tr>
                            <td>{{ $s->Date_Sout->format('d/m/Y') }}</td>
                            <td>{{ $s->Date_Sout->format('H\hi') }}</td>
                            <td>{{ $s->Salle_Sout }}</td>
                            <td>{{ $s->etudiant->full_name }}</td>
                            <td><span class="badge badge-info">{{ \App\Models\professeurs::ROLES[$s->pivot->role] ?? $s->pivot->role }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty">Aucune soutenance à venir.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
