@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <h2 class="page-title">📊 Dashboard Administrateur</h2>

    <div class="cards-container">
        <div class="stat-card blue"><div class="stat-icon">👨‍🎓</div><h3>{{ $stats['etudiants'] }}</h3><p>Étudiants</p></div>
        <div class="stat-card green"><div class="stat-icon">👨‍🏫</div><h3>{{ $stats['professeurs'] }}</h3><p>Professeurs</p></div>
        <div class="stat-card orange"><div class="stat-icon">📄</div><h3>{{ $stats['rapports'] }}</h3><p>Rapports déposés</p></div>
        <div class="stat-card purple"><div class="stat-icon">📅</div><h3>{{ $stats['soutenances'] }}</h3><p>Soutenances planifiées</p></div>
        <div class="stat-card red"><div class="stat-icon">⏳</div><h3>{{ $stats['en_attente'] }}</h3><p>En attente de validation</p></div>
    </div>

    <section class="section">
        <h3 class="section-title">📅 Prochaines soutenances</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>Date</th><th>Heure</th><th>Salle</th><th>Étudiant</th><th>Jury</th><th>Statut</th></tr>
                </thead>
                <tbody>
                    @forelse ($prochaines as $s)
                        <tr>
                            <td>{{ $s->Date_Sout->format('d/m/Y') }}</td>
                            <td>{{ $s->Date_Sout->format('H\hi') }}</td>
                            <td>{{ $s->Salle_Sout }}</td>
                            <td><a href="{{ route('admin.defenses.show', $s->id) }}">{{ $s->etudiant->full_name }}</a></td>
                            <td>{{ $s->juryMembers->count() }} membres</td>
                            <td><span class="badge {{ $s->status_badge }}">{{ $s->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty">Aucune soutenance à venir. <a href="{{ route('admin.defenses.create') }}">Planifier une soutenance</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">⏳ Rapports en attente de validation</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr><th>Étudiant</th><th>Titre</th><th>Type</th><th>Date dépôt</th><th>Encadrant</th><th>Action</th></tr>
                </thead>
                <tbody>
                    @forelse ($documentsEnAttente as $doc)
                        <tr>
                            <td>{{ $doc->etudiant->full_name }}</td>
                            <td>{{ $doc->titre }}</td>
                            <td>{{ $doc->type_libelle }}</td>
                            <td>{{ $doc->date_soumission->format('d/m/Y') }}</td>
                            <td>{{ $doc->etudiant->encadrant?->full_name ?? '—' }}</td>
                            <td>
                                <form class="inline-form" method="POST" action="{{ route('admin.documents.valider', $doc->id) }}">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Valider</button>
                                </form>
                                <a href="{{ route('admin.validation') }}" class="btn btn-secondary btn-sm">Voir</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="empty">Aucun document en attente.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">📈 Avancement</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            @foreach ($progress as $label => [$done, $total])
                @php $pct = $total > 0 ? min(100, round($done / $total * 100)) : 0; @endphp
                @php $color = ['#4db8ff', '#4caf50', '#ff9800'][$loop->index % 3]; @endphp
                <div style="background: #f7f9fc; padding: 20px; border-radius: 10px; border-left: 4px solid {{ $color }};">
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">{{ $label }}</div>
                    <div style="font-size: 32px; font-weight: bold; color: #1e3a5f;">{{ $done }} / {{ $total }}</div>
                    <div class="progress-track" style="margin-top: 10px;"><div class="progress-fill" style="background: {{ $color }}; width: {{ $pct }}%;"></div></div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
