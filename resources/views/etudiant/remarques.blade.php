@extends('etudiant.layout')

@section('title', 'Mes Remarques')

@section('content')
    <h2 class="page-title">Remarques de mes professeurs</h2>

    @php $enAttente = $remarques->where('statut', 'nouvelle')->count(); @endphp

    <div class="cards-container">
        <div class="stat-card blue"><h3>{{ $remarques->count() }}</h3><p>Total remarques</p></div>
        <div class="stat-card orange"><h3>{{ $enAttente }}</h3><p>En attente</p></div>
        <div class="stat-card green"><h3>{{ $remarques->count() - $enAttente }}</h3><p>Traitées</p></div>
    </div>

    @if ($enAttente > 0)
        <div class="alert alert-warning">
            <span>Vous avez <strong>{{ $enAttente }} remarque(s)</strong> à traiter. Après correction, déposez une version corrigée de votre rapport.</span>
        </div>
    @endif

    <section class="section" style="padding: 20px; margin-bottom: 20px;">
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button class="btn btn-primary" onclick="filterRemarks('all', this)">Toutes</button>
            <button class="btn btn-secondary" onclick="filterRemarks('nouvelle', this)">En attente</button>
            <button class="btn btn-secondary" onclick="filterRemarks('traitee', this)">Traitées</button>
        </div>
    </section>

    <section class="section">
        @forelse ($remarques as $r)
            <div class="remark-item" data-status="{{ $r->statut }}" @if ($r->estTraitee()) style="border-left-color: #4caf50; background: #f0fdf4;" @endif>
                <div class="remark-header">
                    <div>
                        <span class="remark-author">{{ $r->professeur->full_name }}</span>
                        <span class="status-badge {{ $r->estTraitee() ? 'status-approved' : 'status-pending' }}" style="margin-left: 10px;">{{ $r->estTraitee() ? 'Traitée' : 'En attente' }}</span>
                    </div>
                    <span class="remark-date">{{ $r->created_at->format('d/m/Y - H:i') }}</span>
                </div>
                <div class="remark-content">
                    @if ($r->sujet)<strong>Sujet : {{ $r->sujet }}</strong><br><br>@endif
                    {{ $r->contenu }}
                    @if ($r->document)<br><span class="muted">Document concerné : {{ $r->document->titre }}</span>@endif
                </div>
                <div style="margin-top: 15px;">
                    @if ($r->estTraitee())
                        <span style="color: #4caf50; font-size: 14px;">Marquée comme traitée le {{ $r->date_resolution->format('d/m/Y') }}</span>
                    @else
                        <form method="POST" action="{{ route('etudiant.remarques.traiter', $r->id) }}" onsubmit="return confirm('Confirmez-vous avoir traité cette remarque ?')">
                            @csrf
                            <button class="btn btn-success">Marquer comme traitée</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="empty">Aucune remarque pour le moment.</p>
        @endforelse
    </section>

    <section class="section">
        <h3 class="section-title">Soumettre une version corrigée</h3>
        <div class="alert alert-info"><span>Après avoir traité les remarques, déposez une nouvelle version de votre rapport en cochant « version corrigée ».</span></div>
        <a href="{{ route('etudiant.depot') }}" class="btn btn-primary">Aller au dépôt</a>
    </section>
@endsection

@section('scripts')
<script>
    function filterRemarks(status, btn) {
        document.querySelectorAll('.section .btn-primary, .section .btn-secondary').forEach(b => {
            if (b.onclick) b.className = 'btn btn-secondary';
        });
        btn.className = 'btn btn-primary';
        document.querySelectorAll('.remark-item').forEach(item => {
            item.style.display = (status === 'all' || item.dataset.status === status) ? '' : 'none';
        });
    }
</script>
@endsection
