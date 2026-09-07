@extends('layouts.admin')

@section('title', 'Planning des Soutenances')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 class="page-title" style="margin: 0;">📋 Planning Global des Soutenances</h2>
        <a href="{{ route('admin.defenses.create') }}" class="btn btn-primary">+ Planifier une soutenance</a>
    </div>

    <section class="section">
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>Date</th><th>Heure</th><th>Salle</th><th>Étudiant</th><th>Filière</th><th>Encadrant</th><th>Jury</th><th>Note finale</th><th>Statut</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse ($defenses as $d)
                        <tr>
                            <td><strong>{{ $d->Date_Sout->format('d/m/Y') }}</strong></td>
                            <td>{{ $d->Date_Sout->format('H\hi') }}</td>
                            <td>{{ $d->Salle_Sout }}</td>
                            <td><strong>{{ $d->etudiant->full_name }}</strong></td>
                            <td>{{ $d->etudiant->filiere ?? '—' }}</td>
                            <td>{{ $d->etudiant->encadrant?->full_name ?? '—' }}</td>
                            <td>{{ $d->juryMembers->count() }} membres</td>
                            <td>{{ $d->Note_finale !== null ? number_format($d->Note_finale, 2).' / 20' : '—' }}</td>
                            <td><span class="badge {{ $d->status_badge }}">{{ $d->status }}</span></td>
                            <td><a href="{{ route('admin.defenses.show', $d->id) }}" class="btn btn-secondary btn-sm">Détails</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="empty">Aucune soutenance planifiée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
