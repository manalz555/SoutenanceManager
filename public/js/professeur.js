// ========================================
// PROFESSEUR.JS - Fonctions JavaScript pour Professeur
// ========================================

// Fonction pour afficher les notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    notification.style.animation = 'slideInRight 0.3s ease';
    
    const icon = type === 'success' ? '✓' : type === 'warning' ? '⚠️' : type === 'danger' ? '❌' : 'ℹ️';
    notification.innerHTML = `<span>${icon}</span><span>${message}</span>`;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Animation CSS pour les notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOutRight {
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

// Animation des cartes au chargement
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.stat-card, .student-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
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
});

// Fonction pour valider les formulaires
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
            } else {
                showNotification('✓ Feedback enregistré avec succès!', 'success');
            }
        });
    }
}

// Fonction pour filtrer par rôle
function filterByRole(role) {
    const cards = document.querySelectorAll('.student-card');
    const rows = document.querySelectorAll('tbody tr[data-role]');
    
    const elements = cards.length > 0 ? cards : rows;
    
    elements.forEach(element => {
        if (role === 'all') {
            element.style.display = '';
        } else {
            element.style.display = element.dataset.role === role ? '' : 'none';
        }
    });
}

// Fonction pour ajouter un feedback
function addFeedback(etudiantId) {
    window.location.href = '/professeur/feedback?etudiant=' + etudiantId;
}

// Fonction pour voir les détails d'un étudiant
function viewStudent(etudiantId) {
    window.location.href = '/professeur/etudiants/' + etudiantId;
}

// Fonction pour voir un rapport
function viewReport(rapportId) {
    window.open('/professeur/rapports/' + rapportId, '_blank');
}

// Fonction pour valider un rapport
function validateReport(rapportId) {
    if (confirm('Valider ce rapport ?')) {
        showNotification('✓ Rapport validé avec succès!', 'success');
        // Ici vous enverriez la requête au backend
    }
}

// Fonction pour rejeter un rapport
function rejectReport(rapportId) {
    const reason = prompt('Raison du rejet :');
    if (reason) {
        showNotification('Rapport rejeté. L\'étudiant sera notifié.', 'warning');
        // Ici vous enverriez la requête au backend
    }
}

// Initialiser les validations de formulaires
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        if (form.id) {
            validateForm(form.id);
        }
    });
});

console.log('✅ professeur.js chargé avec succès!');

