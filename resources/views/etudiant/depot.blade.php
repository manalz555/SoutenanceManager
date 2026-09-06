@extends('etudiant.layout')

@section('title', 'Dépôt de Rapport')

@section('content')
 
    <h2 class="page-title">Dépôt de mon rapport</h2>

    <div class="alert alert-info">
        <span>Formats acceptés : PDF uniquement. Taille maximale : 10 MB</span>
    </div>

    <section class="section">
        <h3 class="section-title">Dossier de stage</h3>
        
        <form action="{{ url('/etudiant/depot/dossier') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="titre-stage">Titre du stage *</label>
                <input 
                    type="text" 
                    id="titre-stage" 
                    name="titre_stage" 
                    placeholder="Ex: Développement d'une application web" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="entreprise">Nom de l'entreprise *</label>
                <input 
                    type="text" 
                    id="entreprise" 
                    name="entreprise" 
                    placeholder="Ex: TechCorp Morocco" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="dossier-file">Fichier du dossier de stage (PDF) *</label>
                
                <div class="file-drop-zone" onclick="document.getElementById('dossier-file').click()">
                    <div style="font-weight: 600; color: #1e3a5f; margin-bottom: 10px;">
                        Glissez-déposez votre fichier ici
                    </div>
                    <div style="color: #666; font-size: 14px;">ou cliquez pour sélectionner</div>
                    <div style="color: #999; font-size: 12px; margin-top: 10px;">
                        Format: PDF | Taille max: 10 MB
                    </div>
                </div>
                
                <input 
                    type="file" 
                    id="dossier-file" 
                    name="dossier" 
                    accept=".pdf" 
                    required 
                    onchange="showFileName(this, 'dossier-name'); handleFileSelect(this)" 
                    style="display: none;"
                >
                
                <div id="dossier-name" class="file-name"></div>
                
                <div class="progress-bar" id="dossier-progress" style="display: none;">
                    <div class="progress-fill" id="dossier-progress-fill" style="width: 0%;"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Déposer le dossier</button>
        </form>

        <div style="margin-top: 30px; padding: 20px; background: #e8fef0; border-radius: 10px; border-left: 4px solid #4caf50;">
            <strong>Dossier déjà déposé</strong><br>
            <span style="color: #666;">Déposé le: 15/12/2024</span><br>
            <a href="#" style="color: #4db8ff; text-decoration: none; font-weight: 600;">Télécharger</a>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">Rapport final de stage</h3>
        
        <form action="{{ url('/etudiant/depot/rapport') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="titre-rapport">Titre du rapport *</label>
                <input 
                    type="text" 
                    id="titre-rapport" 
                    name="titre_rapport" 
                    placeholder="Ex: Rapport de stage PFE - Développement Web" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="resume">Résumé du rapport</label>
                <textarea 
                    id="resume" 
                    name="resume" 
                    placeholder="Décrivez brièvement votre travail (optionnel)..."
                ></textarea>
            </div>

            <div class="form-group">
                <label for="rapport-file">Fichier du rapport final (PDF) *</label>
                
                <div class="file-drop-zone" onclick="document.getElementById('rapport-file').click()">
                    <div style="font-weight: 600; color: #1e3a5f; margin-bottom: 10px;">
                        Glissez-déposez votre fichier ici
                    </div>
                    <div style="color: #666; font-size: 14px;">ou cliquez pour sélectionner</div>
                    <div style="color: #999; font-size: 12px; margin-top: 10px;">
                        Format: PDF | Taille max: 10 MB
                    </div>
                </div>
                
                <input 
                    type="file" 
                    id="rapport-file" 
                    name="rapport" 
                    accept=".pdf" 
                    required 
                    onchange="showFileName(this, 'rapport-name'); handleFileSelect(this)" 
                    style="display: none;"
                >
                
                <div id="rapport-name" class="file-name"></div>
                
                <div class="progress-bar" id="rapport-progress" style="display: none;">
                    <div class="progress-fill" id="rapport-progress-fill" style="width: 0%;"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Soumettre le rapport</button>
        </form>

        <div style="margin-top: 40px;">
            <h4 style="color: #1e3a5f; margin-bottom: 20px;">Historique des versions</h4>
            
            <div style="background: #f9fbfd; padding: 20px; border-radius: 10px; margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong style="color: #1e3a5f;">Version 2 (Actuelle)</strong>
                        <span class="status-badge status-approved">Validé</span>
                        <br>
                        <span style="color: #999; font-size: 14px;">Déposé le: 10/01/2025 à 14:30</span>
                    </div>
                    <a href="#" class="btn btn-secondary">Télécharger</a>
                </div>
            </div>

            <div style="background: #f9fbfd; padding: 20px; border-radius: 10px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong style="color: #1e3a5f;">Version 1</strong>
                        <span class="status-badge status-pending">En révision</span>
                        <br>
                        <span style="color: #999; font-size: 14px;">Déposé le: 05/01/2025 à 10:15</span>
                    </div>
                    <a href="#" class="btn btn-secondary">Télécharger</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">Conseils pour votre rapport</h3>
        <ul style="line-height: 2; color: #555;">
            <li>Vérifiez l'orthographe et la grammaire</li>
            <li>Respectez la structure demandée par votre encadrant</li>
            <li>Incluez les références bibliographiques</li>
            <li>Assurez-vous que toutes les images sont de bonne qualité</li>
            <li>Sauvegardez votre fichier au format PDF/A si possible</li>
        </ul>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZones = document.querySelectorAll('.file-drop-zone');
        
        dropZones.forEach(zone => {
            zone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });
            
            zone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });
            
            zone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const file = files[0];
                    const input = this.parentElement.querySelector('input[type="file"]');
                    if (input) {
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            });
        });
    });
    
    function handleFileSelect(input) {
        const dropZone = input.previousElementSibling;
        if (input.files && input.files[0]) {
            dropZone.style.background = '#e8fef0';
            dropZone.style.borderColor = '#4caf50';
            dropZone.querySelector('div').textContent = 'Fichier sélectionné';
        }
    }
    
    function simulateUpload(progressBarId, progressFillId) {
        const progressBar = document.getElementById(progressBarId);
        const progressFill = document.getElementById(progressFillId);
        
        if (progressBar && progressFill) {
            progressBar.style.display = 'block';
            let width = 0;
            
            const interval = setInterval(() => {
                width += 10;
                progressFill.style.width = width + '%';
                
                if (width >= 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        progressBar.style.display = 'none';
                    }, 1000);
                }
            }, 200);
        }
    }
    
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const fileInputs = form.querySelectorAll('input[type="file"]');
            
            fileInputs.forEach(input => {
                if (input.files && input.files[0]) {
                    const inputId = input.id;
                    
                    if (inputId === 'dossier-file') {
                        simulateUpload('dossier-progress', 'dossier-progress-fill');
                    } else if (inputId === 'rapport-file') {
                        simulateUpload('rapport-progress', 'rapport-progress-fill');
                    }
                }
            });
        });
    });
</script>
@endsection