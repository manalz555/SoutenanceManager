// ========================================
// ETUDIANT.JS - Fonctions JavaScript
// ========================================

// Fonction pour afficher le nom du fichier sélectionné
function showFileName(input, displayId) {
    const display = document.getElementById(displayId);
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2); // MB
        const fileIcon = '📄';
        display.innerHTML = `${fileIcon} <strong>${fileName}</strong> <span style="color: #999;">(${fileSize} MB)</span>`;
        display.style.color = '#4db8ff';
        display.style.fontWeight = '600';
        display.style.padding = '10px';
        display.style.background = '#f0f7ff';
        display.style.borderRadius = '8px';
        display.style.marginTop = '10px';
    } else {
        display.innerHTML = '';
    }
}

// Fonction pour confirmer avant la soumission
function confirmSubmit(formId, message) {
    const form = document.getElementById(formId);
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    }
}

// Fonction pour valider le format PDF
function validatePDF(input) {
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileExtension = fileName.split('.').pop().toLowerCase();
        
        if (fileExtension !== 'pdf') {
            showNotification('❌ Erreur : Seuls les fichiers PDF sont acceptés!', 'warning');
            input.value = '';
            return false;
        }
        
        // Vérifier la taille (max 10MB)
        const fileSize = input.files[0].size / 1024 / 1024; // MB
        if (fileSize > 10) {
            showNotification('❌ Erreur : Le fichier ne doit pas dépasser 10 MB!', 'warning');
            input.value = '';
            return false;
        }
        
        showNotification('✓ Fichier validé avec succès!', 'success');
        return true;
    }
    return false;
}

// Ajouter la validation aux inputs de type file
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            validatePDF(this);
        });
    });
});

// Animation pour les cartes au survol
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.stat-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Fonction pour le menu dropdown utilisateur (optionnel)
function toggleUserMenu() {
    const menu = document.getElementById('userDropdown');
    if (menu) {
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }
}

// Fermer le menu si on clique ailleurs
document.addEventListener('click', function(event) {
    const userInfo = document.querySelector('.user-info');
    const dropdown = document.getElementById('userDropdown');
    
    if (dropdown && !userInfo.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

// Fonction pour afficher les notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    notification.style.animation = 'slideIn 0.3s ease';
    
    const icon = type === 'success' ? '✓' : type === 'warning' ? '⚠️' : 'ℹ️';
    notification.innerHTML = `<span>${icon}</span><span>${message}</span>`;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Animation CSS pour les notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Fonction pour le countdown (page soutenance) - améliorée
function startCountdown(targetDate) {
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = targetDate - now;
        
        if (distance < 0) {
            const daysEl = document.getElementById('days');
            const hoursEl = document.getElementById('hours');
            const minutesEl = document.getElementById('minutes');
            const secondsEl = document.getElementById('seconds');
            
            if (daysEl) daysEl.textContent = '0';
            if (hoursEl) hoursEl.textContent = '0';
            if (minutesEl) minutesEl.textContent = '0';
            if (secondsEl) secondsEl.textContent = '0';
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');
        
        if (daysEl) {
            daysEl.textContent = days;
            daysEl.style.animation = 'pulse 0.5s ease';
        }
        if (hoursEl) {
            hoursEl.textContent = hours;
            hoursEl.style.animation = 'pulse 0.5s ease';
        }
        if (minutesEl) {
            minutesEl.textContent = minutes;
            minutesEl.style.animation = 'pulse 0.5s ease';
        }
        if (secondsEl) {
            secondsEl.textContent = seconds;
            secondsEl.style.animation = 'pulse 0.5s ease';
        }
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000); // Update chaque seconde
}

// Initialiser le countdown si on est sur la page soutenance
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('days')) {
        // Date de la soutenance (à remplacer par la vraie date depuis le backend)
        const soutenanceDate = new Date('2025-01-28T10:00:00').getTime();
        startCountdown(soutenanceDate);
    }
    
    // Ajouter des animations de chargement pour les sections
    const sections = document.querySelectorAll('.section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        setTimeout(() => {
            section.style.transition = 'all 0.5s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Le header et la sidebar restent toujours visibles (pas de masquage au scroll)
    // Code précédent supprimé pour garder le header et la sidebar toujours visibles
});

// Fonction pour télécharger le fichier calendrier (.ics)
function downloadCalendar() {
    const event = {
        title: 'Soutenance PFE',
        description: 'Soutenance de fin d\'études',
        location: 'Salle B102',
        start: '20250128T100000', // Format: YYYYMMDDTHHmmss
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
    
    showNotification('📅 Événement téléchargé! Importez-le dans votre calendrier.', 'success');
}

// Fonction pour prévisualiser le PDF avant upload (optionnel)
function previewPDF(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (file.type === 'application/pdf') {
            const url = URL.createObjectURL(file);
            preview.innerHTML = `<iframe src="${url}" width="100%" height="500px" style="border: 1px solid #ddd; border-radius: 10px;"></iframe>`;
        }
    }
}

// Fonction pour smooth scroll
function smoothScroll(target) {
    document.querySelector(target).scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// Validation de formulaire générique
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#f44336';
                } else {
                    field.style.borderColor = '#e0e0e0';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showNotification('❌ Veuillez remplir tous les champs obligatoires', 'warning');
            }
        });
    }
}

// Initialiser les validations au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter les validations à tous les formulaires
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        if (form.id) {
            validateForm(form.id);
        }
    });
});

console.log('✅ etudiant.js chargé avec succès!');