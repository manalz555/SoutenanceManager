@extends('layouts.admin')

@section('title', 'Planifier une soutenance')

@section('content')
    <h2 class="page-title">📅 Planifier une soutenance</h2>

    <div class="alert alert-info">
        <span>ℹ️</span>
        <span>Choisissez l'étudiant, la date, la salle, puis composez le jury : président, encadrant et rapporteur sont obligatoires, l'examinateur est optionnel.</span>
    </div>

    <section class="section">
        @if ($students->isEmpty())
            <p class="empty">Tous les étudiants ont déjà une soutenance planifiée.</p>
        @else
            <form method="POST" action="{{ route('admin.defenses.store') }}">
                @csrf
                <div class="form-group">
                    <label for="etudiant_id">Étudiant *</label>
                    <select id="etudiant_id" name="etudiant_id" required onchange="prefill(this)">
                        <option value="">Sélectionner...</option>
                        @foreach ($students as $s)
                            <option value="{{ $s->id }}" data-encadrant="{{ $s->encadrant_id }}" data-rapporteur="{{ $s->rapporteur_id }}" @selected(old('etudiant_id') == $s->id)>
                                {{ $s->full_name }} — {{ $s->filiere ?? 'filière non renseignée' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group"><label for="date">Date *</label><input type="date" id="date" name="date" value="{{ old('date') }}" required></div>
                    <div class="form-group"><label for="heure">Heure *</label><input type="time" id="heure" name="heure" value="{{ old('heure', '10:00') }}" required></div>
                    <div class="form-group"><label for="salle">Salle *</label><input type="text" id="salle" name="salle" value="{{ old('salle') }}" placeholder="B102" required></div>
                </div>

                <h3 class="section-title" style="margin-top: 20px;">👥 Composition du jury</h3>
                <div class="form-row">
                    @foreach (['president_id' => 'Président *', 'encadrant_id' => 'Encadrant *', 'rapporteur_id' => 'Rapporteur *', 'examinateur_id' => 'Examinateur'] as $field => $label)
                        <div class="form-group">
                            <label for="{{ $field }}">{{ $label }}</label>
                            <select id="{{ $field }}" name="{{ $field }}" @required(str_ends_with($label, '*'))>
                                <option value="">Sélectionner...</option>
                                @foreach ($teachers as $t)
                                    <option value="{{ $t->id }}" @selected(old($field) == $t->id)>{{ $t->full_name }} ({{ $t->role_libelle }})</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button type="submit" class="btn btn-success">Enregistrer la soutenance</button>
                    <a href="{{ route('admin.defenses') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        @endif
    </section>
@endsection

@section('scripts')
<script>
    // Pré-remplit encadrant et rapporteur à partir des assignations de l'étudiant.
    function prefill(select) {
        const opt = select.selectedOptions[0];
        if (!opt) return;
        if (opt.dataset.encadrant) document.getElementById('encadrant_id').value = opt.dataset.encadrant;
        if (opt.dataset.rapporteur) document.getElementById('rapporteur_id').value = opt.dataset.rapporteur;
    }
</script>
@endsection
