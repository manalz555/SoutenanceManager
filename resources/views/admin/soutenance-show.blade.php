@extends('layouts.admin')

@section('title', 'Soutenance de '.$defense->etudiant->full_name)

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 class="page-title" style="margin: 0;">📅 Soutenance de {{ $defense->etudiant->full_name }}</h2>
        <span class="badge {{ $defense->status_badge }}">{{ $defense->status }}</span>
    </div>

    <div class="cards-container">
        <div class="stat-card blue"><div class="stat-icon">📆</div><h3>{{ $defense->Date_Sout->format('d/m/Y') }}</h3><p>{{ $defense->Date_Sout->format('H\hi') }}</p></div>
        <div class="stat-card green"><div class="stat-icon">🏫</div><h3>{{ $defense->Salle_Sout }}</h3><p>Salle</p></div>
        <div class="stat-card purple"><div class="stat-icon">👥</div><h3>{{ $defense->juryMembers->count() }}</h3><p>Membres du jury</p></div>
        <div class="stat-card orange"><div class="stat-icon">🎓</div><h3>{{ $defense->Note_finale !== null ? number_format($defense->Note_finale, 2) : '—' }}</h3><p>Note finale / 20</p></div>
    </div>

    <section class="section">
        <h3 class="section-title">👥 Jury et notes</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Rôle</th><th>Professeur</th><th>Email</th><th>Note</th><th>Commentaire</th></tr></thead>
                <tbody>
                    @foreach ($defense->juryMembers->sortBy(fn ($m) => array_search($m->pivot->role, ['president', 'encadrant', 'rapporteur', 'examinateur'])) as $m)
                        <tr>
                            <td><span class="badge badge-info">{{ \App\Models\professeurs::ROLES[$m->pivot->role] ?? $m->pivot->role }}</span></td>
                            <td>{{ $m->full_name }}</td>
                            <td>{{ $m->email_prof }}</td>
                            <td>{{ $m->pivot->note !== null ? number_format($m->pivot->note, 2) : '—' }}</td>
                            <td>{{ $m->pivot->commentaire ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">📄 Documents de l'étudiant</h3>
        <div class="table-container">
            <table>
                <thead><tr><th>Type</th><th>Titre</th><th>Déposé le</th><th>Statut</th></tr></thead>
                <tbody>
                    @forelse ($defense->etudiant->documents as $doc)
                        <tr>
                            <td>{{ $doc->type_libelle }}</td>
                            <td>{{ $doc->titre }}</td>
                            <td>{{ $doc->date_soumission->format('d/m/Y') }}</td>
                            <td><span class="badge {{ $doc->statut_badge }}">{{ $doc->statut_libelle }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="empty">Aucun document déposé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div style="display: flex; gap: 15px;">
        <a href="{{ route('admin.defenses') }}" class="btn btn-secondary">← Retour au planning</a>
        <form method="POST" action="{{ route('admin.defenses.destroy', $defense->id) }}" onsubmit="return confirm('Annuler cette soutenance ?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger">Annuler la soutenance</button>
        </form>
    </div>
@endsection
