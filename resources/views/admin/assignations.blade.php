@extends('layouts.admin')

@section('title', 'Assignations')

@section('content')
    <h2 class="page-title">🔗 Assignation des Encadrants et Rapporteurs</h2>

    <div class="alert alert-info">
        <span>ℹ️</span>
        <span>Assignez un encadrant et un rapporteur à chaque étudiant pour le suivi de son stage.</span>
    </div>

    <section class="section">
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>Étudiant</th><th>Filière</th><th>Encadrant</th><th>Rapporteur</th><th>Statut</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($students as $s)
                        <tr>
                            <form method="POST" action="{{ route('admin.assignations.update', $s->id) }}">
                                @csrf
                                <td><strong>{{ $s->full_name }}</strong></td>
                                <td>{{ $s->filiere ?? '—' }}</td>
                                <td>
                                    <select name="encadrant_id" class="select-inline">
                                        <option value="">Sélectionner...</option>
                                        @foreach ($teachers as $t)
                                            <option value="{{ $t->id }}" @selected($s->encadrant_id === $t->id)>{{ $t->full_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="rapporteur_id" class="select-inline">
                                        <option value="">Sélectionner...</option>
                                        @foreach ($teachers as $t)
                                            <option value="{{ $t->id }}" @selected($s->rapporteur_id === $t->id)>{{ $t->full_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    @if ($s->encadrant_id && $s->rapporteur_id)
                                        <span class="badge badge-success">Assigné</span>
                                    @else
                                        <span class="badge badge-warning">En attente</span>
                                    @endif
                                </td>
                                <td><button class="btn btn-success btn-sm">Enregistrer</button></td>
                            </form>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty">Aucun étudiant enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
