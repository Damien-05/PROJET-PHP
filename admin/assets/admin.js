// JavaScript pour le back office
// Version simple pour étudiant

// Au chargement de la page
window.onload = function() {
    console.log('Back office chargé');
    
    // Initialiser les fonctions
    initAlerts();
    initTables();
    initForms();
};

// Gestion des alertes
function initAlerts() {
    var alerts = document.querySelectorAll('.alert');
    
    // Faire disparaître les alertes après 5 secondes
    for (var i = 0; i < alerts.length; i++) {
        setTimeout(function() {
            if (alerts[i]) {
                alerts[i].style.display = 'none';
            }
        }, 5000);
    }
}

// Initialisation des tableaux
function initTables() {
    // TODO: Ajouter le tri des colonnes
    // TODO: Ajouter la pagination
    // TODO: Ajouter la recherche
}

// Initialisation des formulaires
function initForms() {
    // Confirmation avant suppression
    var deleteButtons = document.querySelectorAll('.btn-delete');
    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].onclick = function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                e.preventDefault();
                return false;
            }
        };
    }
}

// Fonction pour afficher/masquer les éléments
function toggleElement(id) {
    var element = document.getElementById(id);
    if (element) {
        if (element.style.display === 'none') {
            element.style.display = 'block';
        } else {
            element.style.display = 'none';
        }
    }
}

// Fonction pour confirmer une action
function confirmAction(message) {
    return confirm(message || 'Êtes-vous sûr ?');
}

// Fonction pour les modales simples
function openModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
    }
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Fermer les modales en cliquant en dehors
window.onclick = function(event) {
    var modals = document.querySelectorAll('.modal');
    for (var i = 0; i < modals.length; i++) {
        if (event.target == modals[i]) {
            modals[i].style.display = 'none';
        }
    }
};

// Fonction pour valider les formulaires
function validateForm(formId) {
    var form = document.getElementById(formId);
    if (!form) return false;
    
    var requiredFields = form.querySelectorAll('[required]');
    
    for (var i = 0; i < requiredFields.length; i++) {
        if (!requiredFields[i].value.trim()) {
            alert('Veuillez remplir tous les champs obligatoires.');
            requiredFields[i].focus();
            return false;
        }
    }
    
    return true;
}

// Fonction pour formater les dates
function formatDate(dateString) {
    var date = new Date(dateString);
    var day = date.getDate().toString().padStart(2, '0');
    var month = (date.getMonth() + 1).toString().padStart(2, '0');
    var year = date.getFullYear();
    
    return day + '/' + month + '/' + year;
}

// Fonction de recherche dans les tableaux
function searchTable(inputId, tableId) {
    var input = document.getElementById(inputId);
    var table = document.getElementById(tableId);
    
    if (!input || !table) return;
    
    input.onkeyup = function() {
        var filter = input.value.toLowerCase();
        var rows = table.getElementsByTagName('tr');
        
        for (var i = 1; i < rows.length; i++) {
            var row = rows[i];
            var cells = row.getElementsByTagName('td');
            var found = false;
            
            for (var j = 0; j < cells.length; j++) {
                if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
            
            row.style.display = found ? '' : 'none';
        }
    };
}