@extends('layouts.professeur')

@section('title', 'Mes Étudiants')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 class="page-title" style="margin: 0;">👨‍🎓 Mes Étudiants</h2>
        <div class="filters">
            <button class="filter-btn active" onclick="filterByRole('all', this)">Tous</button>
            <button class="filter-btn" onclick="filterByRole('encadrant', this)">Encadrant</button>
            <button class="filter-btn" onclick="filterByRole('rapporteur', this)">Rapporteur</button>
        </div>
    </div>

    <section class="section">
        @if ($etudiants->isEmpty())
            <p class="empty">Aucun étudiant ne vous est assigné pour le moment.</p>
        @else
            <div class="student-grid">
                @foreach ($etudiants as $e)
                    @php $rapport = $e->documents->firstWhere('type', 'rapport'); @endphp
                    <div class="student-card" data-role="{{ $e->mon_role }}">
                        <div class="student-card-header">
                            <div class="student-name">{{ $e->full_name }}</div>
                            <span class="badge {{ $e->mon_role === 'encadrant' ? 'badge-info' : 'badge-warning' }}">{{ ucfirst($e->mon_role) }}</span>
                        </div>
                        <div class="student-info">📧 {{ $e->email }}</div>
                        <div class="student-info">🎓 {{ $e->filiere ?? '—' }} · {{ $e->annee_universitaire ?? '—' }}</div>
                        <div class="student-info">📄 Rapport : <strong>{{ $rapport ? $rapport->statut_libelle : 'Non déposé' }}</strong></div>
                        <div class="student-info">📅 Soutenance : <strong>{{ $e->soutenance ? $e->soutenance->Date_Sout->format('d/m/Y \à H\hi') : 'À planifier' }}</strong></div>
                        <div class="student-actions">
                            <a href="{{ route('professor.etudiant.show', $e->id) }}" class="btn btn-primary btn-sm">Voir détails</a>
                            <a href="{{ route('professor.etudiant.show', $e->id) }}#remarque" class="btn btn-success btn-sm">Feedback</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection

@section('scripts')
<script>
    function filterByRole(role, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.student-card').forEach(card => {
            card.style.display = (role === 'all' || card.dataset.role === role) ? '' : 'none';
        });
    }
</script>
@endsection
