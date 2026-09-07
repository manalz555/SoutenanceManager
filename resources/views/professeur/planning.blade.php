@extends('layouts.professeur')

@section('title', 'Planning des Soutenances')

@section('content')
    <h2 class="page-title">📅 Planning des soutenances &amp; notation</h2>

    <div class="alert alert-info">
        <span>ℹ️</span>
        <span>Vous pouvez saisir votre note dès que la soutenance a eu lieu. La note finale est calculée automatiquement quand tous les membres du jury ont noté.</span>
    </div>

    <section class="section">
        <div class="table-container">
            <table>
                <thead><tr><th>Date</th><th>Heure</th><th>Salle</th><th>Étudiant</th><th>Mon rôle</th><th>Jury</th><th>Statut</th><th>Ma note</th></tr></thead>
                <tbody>
                    @forelse ($soutenances as $s)
                        <tr>
                            <td><strong>{{ $s->Date_Sout->format('d/m/Y') }}</strong></td>
                            <td>{{ $s->Date_Sout->format('H\hi') }}</td>
                            <td>{{ $s->Salle_Sout }}</td>
                            <td><a href="{{ route('professor.etudiant.show', $s->etudiant_id) }}"><strong>{{ $s->etudiant->full_name }}</strong></a></td>
                            <td><span class="badge badge-info">{{ \App\Models\professeurs::ROLES[$s->pivot->role] ?? $s->pivot->role }}</span></td>
                            <td>{{ $s->juryMembers->count() }} membres</td>
                            <td>
                                <span class="badge {{ $s->status_badge }}">{{ $s->status }}</span>
                                @if ($s->Note_finale !== null)
                                    <br><span class="muted">Finale : {{ number_format($s->Note_finale, 2) }} / 20</span>
                                @endif
                            </td>
                            <td>
                                @if ($s->Date_Sout->isPast())
                                    <form method="POST" action="{{ route('professor.soutenances.noter', $s->id) }}" class="note-form">
                                        @csrf
                                        <input type="number" name="note" min="0" max="20" step="0.25" value="{{ $s->pivot->note }}" required>
                                        <input type="text" name="commentaire" value="{{ $s->pivot->commentaire }}" placeholder="Commentaire">
                                        <button class="btn btn-success btn-sm">{{ $s->pivot->note !== null ? 'Modifier' : 'Noter' }}</button>
                                    </form>
                                @else
                                    <span class="muted">Après la soutenance</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="empty">Vous ne faites partie d'aucun jury pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
