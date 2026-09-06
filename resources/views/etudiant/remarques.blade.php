@extends('etudiant.layout')

@section('title', 'Mes Remarques')

@section('content')
    <h2 class="page-title">Remarques du rapporteur</h2>

    <div class="cards-container">
        <div class="stat-card blue">
            <h3>5</h3>
            <p>Total remarques</p>
        </div>
        
        <div class="stat-card orange">
            <h3>2</h3>
            <p>En attente</p>
        </div>
        
        <div class="stat-card green">
            <h3>3</h3>
            <p>Traitées</p>
        </div>
    </div>

    <div class="alert alert-warning">
        <span>Vous avez <strong>2 remarques</strong> qui nécessitent des corrections. Merci de soumettre une version corrigée.</span>
    </div>

    <section class="section" style="padding: 20px; margin-bottom: 20px;">
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button class="btn btn-primary" onclick="filterRemarks('all')" style="padding: 10px 20px; font-size: 14px;">
                Toutes
            </button>
            
            <button class="btn btn-secondary" onclick="filterRemarks('pending')" style="padding: 10px 20px; font-size: 14px;">
                En attente
            </button>
            
            <button class="btn btn-secondary" onclick="filterRemarks('approved')" style="padding: 10px 20px; font-size: 14px;">
                Traitées
            </button>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">Remarques récentes</h3>

        <div class="remark-item" data-remark-id="0">
            <div class="remark-header">
                <div>
                    <span class="remark-author">Dr. Mohammed Alami (Rapporteur)</span>
                    <span class="status-badge status-pending" style="margin-left: 10px;">En attente</span>
                </div>
                <span class="remark-date">10/01/2025 - 16:45</span>
            </div>
            <div class="remark-content">
                <strong>Sujet : Références bibliographiques</strong><br><br>
                Excellent travail sur la partie technique. Cependant, merci d'ajouter plus de références bibliographiques dans la section "État de l'art" (pages 15-20). Il manque notamment des références récentes (2023-2024) sur les technologies utilisées.
            </div>
            <div style="margin-top: 15px;">
                <button class="btn btn-success" onclick="openResponseModal(0)">Marquer comme traité</button>
            </div>
        </div>

        <div class="remark-item" data-remark-id="1">
            <div class="remark-header">
                <div>
                    <span class="remark-author">Dr. Mohammed Alami (Rapporteur)</span>
                    <span class="status-badge status-pending" style="margin-left: 10px;">En attente</span>
                </div>
                <span class="remark-date">10/01/2025 - 16:30</span>
            </div>
            <div class="remark-content">
                <strong>Sujet : Chapitre 4 - Résultats</strong><br><br>
                La méthodologie est bien expliquée. Pourriez-vous détailler davantage les résultats obtenus dans le chapitre 4 ? Il serait intéressant d'ajouter des graphiques comparatifs et une analyse plus approfondie des performances.
            </div>
            <div style="margin-top: 15px;">
                <button class="btn btn-success" onclick="openResponseModal(1)">Marquer comme traité</button>
            </div>
        </div>

        <div class="remark-item" data-remark-id="2" style="border-left-color: #4caf50; background: #f0fdf4;">
            <div class="remark-header">
                <div>
                    <span class="remark-author">Dr. Mohammed Alami (Rapporteur)</span>
                    <span class="status-badge status-approved" style="margin-left: 10px;">Traité</span>
                </div>
                <span class="remark-date">08/01/2025 - 10:20</span>
            </div>
            <div class="remark-content">
                <strong>Sujet : Introduction</strong><br><br>
                L'introduction est claire et bien structurée. Bonne présentation de la problématique.
            </div>
            <div style="margin-top: 10px; color: #4caf50; font-size: 14px;">
                Marqué comme traité le 09/01/2025
            </div>
        </div>

        <div class="remark-item" data-remark-id="3" style="border-left-color: #4caf50; background: #f0fdf4;">
            <div class="remark-header">
                <div>
                    <span class="remark-author">Prof. Fatima Zahra (Encadrant)</span>
                    <span class="status-badge status-approved" style="margin-left: 10px;">Traité</span>
                </div>
                <span class="remark-date">07/01/2025 - 14:15</span>
            </div>
            <div class="remark-content">
                <strong>Sujet : Diagrammes UML</strong><br><br>
                Merci de corriger le diagramme de classes en page 35. La relation entre les classes User et Role n'est pas correctement représentée.
            </div>
            <div style="margin-top: 10px; color: #4caf50; font-size: 14px;">
                Corrigé et validé le 08/01/2025
            </div>
        </div>

        <div class="remark-item" data-remark-id="4" style="border-left-color: #4caf50; background: #f0fdf4;">
            <div class="remark-header">
                <div>
                    <span class="remark-author">Prof. Fatima Zahra (Encadrant)</span>
                    <span class="status-badge status-approved" style="margin-left: 10px;">Traité</span>
                </div>
                <span class="remark-date">05/01/2025 - 11:00</span>
            </div>
            <div class="remark-content">
                <strong>Sujet : Format général</strong><br><br>
                Le format du document est conforme aux exigences. Bon travail !
            </div>
            <div style="margin-top: 10px; color: #4caf50; font-size: 14px;">
                Aucune action requise
            </div>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">Soumettre une version corrigée</h3>
        
        <div class="alert alert-info">
            <span>Après avoir traité les remarques, soumettez une nouvelle version de votre rapport.</span>
        </div>
        
        <form action="{{ url('/etudiant/soumettre-correction') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="corrections">Résumé des corrections effectuées</label>
                <textarea 
                    id="corrections" 
                    name="corrections" 
                    placeholder="Décrivez brièvement les modifications apportées..." 
                    required
                ></textarea>
            </div>

            <div class="form-group">
                <label for="rapport-corrige">Rapport corrigé (PDF)</label>
                <div class="file-upload-wrapper">
                    <label for="rapport-corrige" class="file-upload-label">
                        Choisir le fichier corrigé
                    </label>
                    <input 
                        type="file" 
                        id="rapport-corrige" 
                        name="rapport_corrige" 
                        accept=".pdf" 
                        required 
                        onchange="showFileName(this, 'corrige-name')"
                    >
                </div>
                <div id="corrige-name" class="file-name"></div>
            </div>

            <button type="submit" class="btn btn-success">Soumettre la version corrigée</button>
        </form>
    </section>

    <div id="responseModal" class="modal-overlay" onclick="if(event.target === this) closeResponseModal()">
        <div class="modal-content">
            <h3 style="color: #1e3a5f; margin-bottom: 20px;">Marquer comme traité</h3>
            <p style="color: #666; margin-bottom: 25px;">
                Confirmez-vous que cette remarque a été traitée et corrigée dans votre rapport ?
            </p>
            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button class="btn btn-secondary" onclick="closeResponseModal()">Annuler</button>
                <button class="btn btn-success" onclick="markAsTreated()">Confirmer</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let currentRemarkId = null;
    
    function openResponseModal(remarkId) {
        currentRemarkId = remarkId;
        const modal = document.getElementById('responseModal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
   
    function closeResponseModal() {
        const modal = document.getElementById('responseModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        currentRemarkId = null;
    }
    
    function markAsTreated() {
        if (currentRemarkId !== null) {
            const remarkItem = document.querySelector(`[data-remark-id="${currentRemarkId}"]`);
            
            if (remarkItem) {
                remarkItem.style.transition = 'all 0.5s ease';
                remarkItem.style.borderLeftColor = '#4caf50';
                remarkItem.style.background = '#f0fdf4';
                
                const badge = remarkItem.querySelector('.status-badge');
                if (badge) {
                    badge.className = 'status-badge status-approved';
                    badge.textContent = 'Traité';
                }
                
                const actionDiv = remarkItem.querySelector('div[style*="margin-top: 15px"]');
                if (actionDiv) {
                    const today = new Date().toLocaleDateString('fr-FR');
                    actionDiv.innerHTML = `<div style="margin-top: 10px; color: #4caf50; font-size: 14px;">Marqué comme traité le ${today}</div>`;
                }
            }
            
            showNotification('Remarque marquée comme traitée avec succès!', 'success');
        }
        
        closeResponseModal();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const remarkItems = document.querySelectorAll('.remark-item');
        remarkItems.forEach((item, index) => {
            item.setAttribute('data-remark-id', index);
            
            const button = item.querySelector('button');
            if (button) {
                button.onclick = () => openResponseModal(index);
            }
        });
    });
    
    function filterRemarks(status) {
        const remarks = document.querySelectorAll('.remark-item');
        
        remarks.forEach(remark => {
            const badge = remark.querySelector('.status-badge');
            
            if (badge) {
                if (status === 'all') {
                    remark.style.display = 'block';
                    remark.style.animation = 'fadeIn 0.3s ease';
                }
                else if (status === 'pending' && badge.classList.contains('status-pending')) {
                    remark.style.display = 'block';
                    remark.style.animation = 'fadeIn 0.3s ease';
                }
                else if (status === 'approved' && badge.classList.contains('status-approved')) {
                    remark.style.display = 'block';
                    remark.style.animation = 'fadeIn 0.3s ease';
                }
                else {
                    remark.style.display = 'none';
                }
            }
        });
        
        const filterButtons = document.querySelectorAll('.section button');
        filterButtons.forEach(btn => {
            if (btn.textContent.includes('Toutes') && status === 'all') {
                btn.className = 'btn btn-primary';
            } else if (btn.textContent.includes('En attente') && status === 'pending') {
                btn.className = 'btn btn-primary';
            } else if (btn.textContent.includes('Traitées') && status === 'approved') {
                btn.className = 'btn btn-primary';
            } else {
                btn.className = 'btn btn-secondary';
            }
        });
    }
</script>
@endsection