@extends('etudiant.layout')

@section('title', 'Ma Soutenance')

@section('content')
    <h2 class="page-title">Informations de ma soutenance</h2>

    @if (! $soutenance)
        <div class="alert alert-warning">
            <span>Votre soutenance n'est pas encore planifiée. Vous serez informé dès que l'administration aura fixé la date et le jury.</span>
        </div>
    @else
        @php $roles = \App\Models\professeurs::ROLES; $couleurs = ['president' => '#ffd700', 'encadrant' => '#4db8ff', 'rapporteur' => '#ff9800', 'examinateur' => '#9c27b0']; @endphp

        <div class="alert {{ $soutenance->Note_finale !== null ? 'alert-info' : 'alert-success' }}">
            <span>
                @if ($soutenance->Note_finale !== null)
                    <strong>Soutenance terminée.</strong> Note finale : <strong>{{ number_format($soutenance->Note_finale, 2) }} / 20</strong>.
                @elseif ($soutenance->Date_Sout->isPast())
                    <strong>Votre soutenance a eu lieu.</strong> Le jury est en train de délibérer.
                @else
                    <strong>Votre soutenance a été planifiée !</strong> Préparez votre présentation.
                @endif
            </span>
        </div>

        <section class="section">
            <h3 class="section-title">Détails de la soutenance</h3>
            <div class="info-grid">
                <div class="info-item" style="border-left-color: #4db8ff;"><div class="info-label">Date</div><div class="info-value">{{ $soutenance->Date_Sout->translatedFormat('l d F Y') }}</div></div>
                <div class="info-item" style="border-left-color: #4db8ff;"><div class="info-label">Heure</div><div class="info-value">{{ $soutenance->Date_Sout->format('H\hi') }} - {{ $soutenance->Date_Sout->copy()->addMinutes(45)->format('H\hi') }}</div></div>
                <div class="info-item" style="border-left-color: #4db8ff;"><div class="info-label">Salle</div><div class="info-value">{{ $soutenance->Salle_Sout }}</div></div>
                <div class="info-item" style="border-left-color: #4db8ff;"><div class="info-label">Durée</div><div class="info-value">45 minutes</div></div>
            </div>
        </section>

        <section class="section">
            <h3 class="section-title">Composition du jury</h3>
            <div class="jury-grid">
                @foreach ($soutenance->juryMembers->sortBy(fn ($m) => array_search($m->pivot->role, array_keys($roles))) as $m)
                    <div class="jury-member" style="border-color: {{ $couleurs[$m->pivot->role] ?? '#ccc' }};">
                        <div class="jury-role">{{ $roles[$m->pivot->role] ?? $m->pivot->role }}</div>
                        <div class="jury-name">{{ $m->full_name }}</div>
                        <div style="color: #999; font-size: 13px; margin-top: 8px;">{{ $m->email_prof }}</div>
                        @if ($soutenance->Note_finale !== null && $m->pivot->commentaire)
                            <div style="color: #555; font-size: 13px; margin-top: 8px; font-style: italic;">« {{ $m->pivot->commentaire }} »</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        <section class="section">
            <h3 class="section-title">Déroulement de la soutenance</h3>
            <div style="border-left: 4px solid #4db8ff; padding-left: 25px;">
                @foreach ([['Présentation (20 minutes)', 'Vous présentez votre travail devant le jury à l\'aide de slides.'], ['Questions du jury (20 minutes)', 'Le jury pose des questions sur votre travail, votre méthodologie et vos résultats.'], ['Délibération (5 minutes)', 'Le jury délibère en votre absence pour décider de la note finale.'], ['Annonce des résultats', 'Le président annonce votre note et les appréciations du jury.']] as $i => [$titre, $texte])
                    <div style="margin-bottom: 25px;">
                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                            <div style="background: {{ $i === 3 ? '#4caf50' : '#4db8ff' }}; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">{{ $i + 1 }}</div>
                            <strong style="color: #1e3a5f; font-size: 18px;">{{ $titre }}</strong>
                        </div>
                        <p style="color: #666; margin-left: 50px;">{{ $texte }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="section">
            <h3 class="section-title">Documents à préparer</h3>
            <ul style="line-height: 2.2; color: #555;">
                <li><strong>Rapport final imprimé</strong> (une copie par membre du jury)</li>
                <li><strong>Support de présentation</strong> (PowerPoint/PDF sur clé USB)</li>
                <li><strong>Carte d'étudiant</strong></li>
                <li><strong>Attestation de stage</strong> (si applicable)</li>
            </ul>
        </section>

        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button class="btn btn-primary" onclick="window.print()">Imprimer la convocation</button>
            <button class="btn btn-secondary" onclick="downloadCalendar()">Ajouter au calendrier</button>
        </div>
    @endif
@endsection

@section('scripts')
@if ($soutenance)
<script>
    function downloadCalendar() {
        const start = '{{ $soutenance->Date_Sout->format('Ymd\THis') }}';
        const end = '{{ $soutenance->Date_Sout->copy()->addMinutes(45)->format('Ymd\THis') }}';
        const ics = ['BEGIN:VCALENDAR', 'VERSION:2.0', 'PRODID:-//SoutenanceManager//FR', 'BEGIN:VEVENT',
            'UID:' + Date.now() + '@soutenancemanager', 'DTSTART:' + start, 'DTEND:' + end,
            'SUMMARY:Soutenance PFE', 'LOCATION:Salle {{ $soutenance->Salle_Sout }}', 'END:VEVENT', 'END:VCALENDAR'].join('\r\n');
        const link = document.createElement('a');
        link.href = URL.createObjectURL(new Blob([ics], { type: 'text/calendar' }));
        link.download = 'soutenance.ics';
        link.click();
    }
</script>
@endif
@endsection
