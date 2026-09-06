@extends('etudiant.layout')

@section('title', 'Dashboard')

@section('content')
    <h2 class="page-title">
        Bienvenue, 
        @if(isset($etudiant) && $etudiant)
            {{ $etudiant->prenom }} {{ $etudiant->nom }}!
        @else
            Étudiant!
        @endif
    </h2>

    <div class="cards-container">
        <div class="stat-card blue">
            <h3>1</h3>
            <p>Rapport déposé</p>
        </div>
        
        <div class="stat-card green">
            <h3>Validé</h3>
            <p>Statut du rapport</p>
        </div>
        
        <div class="stat-card orange">
            <h3>2</h3>
            <p>Remarques reçues</p>
        </div>
        
        <div class="stat-card purple">
            <h3>15 Jours</h3>
            <p>Avant soutenance</p>
        </div>
    </div>

    <div class="alert alert-info">
        <span>Votre soutenance est prévue le <strong>28 Janvier 2025 à 10h00</strong> en salle <strong>B102</strong>.</span>
    </div>

    <section class="section">
        <h3 class="section-title">État de mon parcours</h3>
        
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Dossier de stage</div>
                <div class="info-value">Déposé</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Rapport final</div>
                <div class="info-value">Validé</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Encadrant assigné</div>
                <div class="info-value">Oui</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Jury constitué</div>
                <div class="info-value">Complet</div>
            </div>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">Dernières remarques du rapporteur</h3>
        
        <div class="remark-item">
            <div class="remark-header">
                <span class="remark-author">Dr. Mohammed Alami</span>
                <span class="remark-date">10/01/2025</span>
            </div>
            <div class="remark-content">
                Excellent travail sur la partie technique. Cependant, merci d'ajouter plus de références bibliographiques dans la section État de l'art.
            </div>
        </div>
        
        <div class="remark-item">
            <div class="remark-header">
                <span class="remark-author">Dr. Mohammed Alami</span>
                <span class="remark-date">08/01/2025</span>
            </div>
            <div class="remark-content">
                La méthodologie est bien expliquée. Pourriez-vous détailler davantage les résultats obtenus dans le chapitre 4 ?
            </div>
        </div>
        
        <a href="{{ url('/etudiant/remarques') }}" class="btn btn-primary">Voir toutes les remarques</a>
    </section>

    <section class="section">
        <h3 class="section-title">Informations de ma soutenance</h3>
        
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Date</div>
                <div class="info-value">28 Janvier 2025</div>
            </div>
            <div class="info-item">
                <div class="info-label">Heure</div>
                <div class="info-value">10h00</div>
            </div>
            <div class="info-item">
                <div class="info-label">Salle</div>
                <div class="info-value">B102</div>
            </div>
            <div class="info-item">
                <div class="info-label">Durée</div>
                <div class="info-value">45 minutes</div>
            </div>
        </div>
        
        <a href="{{ url('/etudiant/soutenance') }}" class="btn btn-primary" style="margin-top: 20px;">Voir les détails complets</a>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.stat-card');
        
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
        
        const statNumbers = document.querySelectorAll('.stat-card h3');
        
        statNumbers.forEach(stat => {
            const finalValue = stat.textContent;
            
            if (!isNaN(finalValue) && finalValue !== '') {
                animateNumber(stat, 0, parseInt(finalValue), 1000);
            }
        });
    });
    
    function animateNumber(element, start, end, duration) {
        let startTimestamp = null;
        
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            
            element.textContent = Math.floor(progress * (end - start) + start);
            
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        
        window.requestAnimationFrame(step);
    }
</script>
@endsection