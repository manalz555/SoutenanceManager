@extends('etudiant.layout')

@section('title', 'Ma Soutenance')

@section('content')
    <h2 class="page-title">Informations de ma soutenance</h2>

    <div class="alert alert-success">
        <span><strong>Votre soutenance a été planifiée!</strong> Vous recevrez une notification par email 24h avant.</span>
    </div>

    <section class="section">
        <h3 class="section-title">Détails de la soutenance</h3>
        
        <div class="info-grid">
            <div class="info-item" style="border-left-color: #4db8ff;">
                <div class="info-label">Date</div>
                <div class="info-value">Mardi 28 Janvier 2025</div>
            </div>
            
            <div class="info-item" style="border-left-color: #4db8ff;">
                <div class="info-label">Heure</div>
                <div class="info-value">10h00 - 10h45</div>
            </div>
            
            <div class="info-item" style="border-left-color: #4db8ff;">
                <div class="info-label">Salle</div>
                <div class="info-value">B102 - Bâtiment B</div>
            </div>
            
            <div class="info-item" style="border-left-color: #4db8ff;">
                <div class="info-label">Durée</div>
                <div class="info-value">45 minutes</div>
            </div>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">Composition du jury</h3>
        
        <div class="jury-grid">
            <div class="jury-member" style="border-color: #ffd700;">
                <div class="jury-role">Président</div>
                <div class="jury-name">Prof. Ahmed Benjelloun</div>
                <div style="color: #999; font-size: 13px; margin-top: 8px;">Département Informatique</div>
            </div>

            <div class="jury-member" style="border-color: #4db8ff;">
                <div class="jury-role">Encadrant</div>
                <div class="jury-name">Prof. Fatima Zahra</div>
                <div style="color: #999; font-size: 13px; margin-top: 8px;">Encadrant académique</div>
            </div>

            <div class="jury-member" style="border-color: #ff9800;">
                <div class="jury-role">Rapporteur</div>
                <div class="jury-name">Dr. Mohammed Alami</div>
                <div style="color: #999; font-size: 13px; margin-top: 8px;">Évaluateur principal</div>
            </div>

            <div class="jury-member" style="border-color: #9c27b0;">
                <div class="jury-role">Examinateur</div>
                <div class="jury-name">Dr. Youssef Idrissi</div>
                <div style="color: #999; font-size: 13px; margin-top: 8px;">Département Génie Logiciel</div>
            </div>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">Déroulement de la soutenance</h3>
        
        <div style="border-left: 4px solid #4db8ff; padding-left: 25px;">
            <div style="margin-bottom: 25px;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                    <div style="background: #4db8ff; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">1</div>
                    <strong style="color: #1e3a5f; font-size: 18px;">Présentation (20 minutes)</strong>
                </div>
                <p style="color: #666; margin-left: 50px;">
                    Vous présentez votre travail devant le jury à l'aide de slides (PowerPoint/PDF).
                </p>
            </div>

            <div style="margin-bottom: 25px;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                    <div style="background: #4db8ff; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">2</div>
                    <strong style="color: #1e3a5f; font-size: 18px;">Questions du jury (20 minutes)</strong>
                </div>
                <p style="color: #666; margin-left: 50px;">
                    Le jury pose des questions sur votre travail, méthodologie et résultats.
                </p>
            </div>

            <div style="margin-bottom: 25px;">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                    <div style="background: #4db8ff; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">3</div>
                    <strong style="color: #1e3a5f; font-size: 18px;">Délibération (5 minutes)</strong>
                </div>
                <p style="color: #666; margin-left: 50px;">
                    Le jury délibère en votre absence pour décider de la note finale.
                </p>
            </div>

            <div>
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                    <div style="background: #4caf50; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">4</div>
                    <strong style="color: #1e3a5f; font-size: 18px;">Annonce des résultats</strong>
                </div>
                <p style="color: #666; margin-left: 50px;">
                    Le président annonce votre note et les appréciations du jury.
                </p>
            </div>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">Conseils pour réussir votre soutenance</h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div style="background: #f0f7ff; padding: 20px; border-radius: 10px; border-left: 4px solid #4db8ff;">
                <strong style="color: #1e3a5f;">Préparation</strong>
                <ul style="margin-top: 10px; color: #666; line-height: 1.8;">
                    <li>Répétez votre présentation plusieurs fois</li>
                    <li>Préparez 15-20 slides maximum</li>
                    <li>Chronométrez-vous</li>
                </ul>
            </div>

            <div style="background: #f0fdf4; padding: 20px; border-radius: 10px; border-left: 4px solid #4caf50;">
                <strong style="color: #1e3a5f;">Présentation</strong>
                <ul style="margin-top: 10px; color: #666; line-height: 1.8;">
                    <li>Parlez clairement et avec confiance</li>
                    <li>Maintenez le contact visuel</li>
                    <li>Utilisez des exemples concrets</li>
                </ul>
            </div>

            <div style="background: #fff5e8; padding: 20px; border-radius: 10px; border-left: 4px solid #ff9800;">
                <strong style="color: #1e3a5f;">Questions</strong>
                <ul style="margin-top: 10px; color: #666; line-height: 1.8;">
                    <li>Écoutez bien avant de répondre</li>
                    <li>N'hésitez pas à demander des précisions</li>
                    <li>Restez calme et professionnel</li>
                </ul>
            </div>

            <div style="background: #f5e8ff; padding: 20px; border-radius: 10px; border-left: 4px solid #9c27b0;">
                <strong style="color: #1e3a5f;">Le jour J</strong>
                <ul style="margin-top: 10px; color: #666; line-height: 1.8;">
                    <li>Arrivez 15 minutes en avance</li>
                    <li>Habillez-vous de manière professionnelle</li>
                    <li>Apportez votre rapport imprimé</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section">
        <h3 class="section-title">Documents à préparer</h3>
        
        <div class="alert alert-info">
            <span>Assurez-vous d'avoir ces documents le jour de la soutenance</span>
        </div>
        
        <ul style="line-height: 2.2; color: #555;">
            <li><strong>Rapport final imprimé</strong> (4 copies minimum : président, encadrant, rapporteur, examinateur)</li>
            <li><strong>Support de présentation</strong> (PowerPoint/PDF sur clé USB + envoyé par email)</li>
            <li><strong>Carte d'étudiant</strong></li>
            <li><strong>Attestation de stage</strong> (si applicable)</li>
        </ul>
    </section>

    <div style="display: flex; gap: 15px; margin-top: 30px;">
        <button class="btn btn-primary" onclick="window.print()">Imprimer la convocation</button>
        <button class="btn btn-secondary" onclick="downloadCalendar()">Ajouter au calendrier</button>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const juryMembers = document.querySelectorAll('.jury-member');
        
        juryMembers.forEach(member => {
            member.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
                this.style.transition = 'transform 0.3s ease';
            });
            
            member.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    });
    
    function downloadCalendar() {
        const event = {
            title: 'Soutenance PFE',
            description: 'Soutenance de fin d\'études',
            location: 'Salle B102',
            start: '20250128T100000',
            end: '20250128T104500',
        };
        
        const icsContent = `BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//SoutenanceManager//FR
BEGIN:VEVENT
UID:${Date.now()}@soutenancemanager.com
DTSTAMP:${new Date().toISOString().replace(/[-:]/g, '').split('.')[0]}Z
DTSTART:${event.start}
DTEND:${event.end}
SUMMARY:${event.title}
DESCRIPTION:${event.description}
LOCATION:${event.location}
STATUS:CONFIRMED
END:VEVENT
END:VCALENDAR`;
        
        const blob = new Blob([icsContent], { type: 'text/calendar' });
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'soutenance.ics';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
        
        showNotification('Événement téléchargé! Importez-le dans votre calendrier.', 'success');
    }
</script>
@endsection