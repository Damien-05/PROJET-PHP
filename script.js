// Script pour le site du cabinet dentaire
// Version étudiant - Code simple pour l'apprentissage

// Variables pour le formulaire
var currentStep = 1;
var selectedService = null;
var selectedDate = null;
var selectedTime = null;

// Menu mobile
function toggleMenu() {
    var navMenu = document.getElementById('nav-menu');
    if (navMenu.style.display === 'flex') {
        navMenu.style.display = 'none';
    } else {
        navMenu.style.display = 'flex';
    }
}

// Fermer le menu quand on clique ailleurs
document.addEventListener('click', function(event) {
    var navMenu = document.getElementById('nav-menu');
    var menuButton = document.querySelector('.menu-toggle');
    
    if (navMenu && menuButton) {
        if (!navMenu.contains(event.target) && !menuButton.contains(event.target)) {
            navMenu.style.display = 'none';
        }
    }
});

// Quand la page se charge
window.onload = function() {
    // Si on est sur la page de rendez-vous
    if (document.getElementById('appointmentForm')) {
        setupAppointmentForm();
    }
    
    // Si il y a un calendrier
    if (document.getElementById('calendar')) {
        makeCalendar();
    }
};

// Initialiser le formulaire de rendez-vous
function setupAppointmentForm() {
    var serviceOptions = document.querySelectorAll('.service-option');
    
    // Pour chaque option de service
    for (var i = 0; i < serviceOptions.length; i++) {
        serviceOptions[i].onclick = function() {
            // Enlever selected de tous les autres
            for (var j = 0; j < serviceOptions.length; j++) {
                serviceOptions[j].classList.remove('selected');
            }
            
            // Ajouter selected à celui cliqué
            this.classList.add('selected');
            
            // Sauvegarder le service choisi
            selectedService = {
                type: this.getAttribute('data-service'),
                duration: this.getAttribute('data-duration'),
                price: this.getAttribute('data-price'),
                name: this.querySelector('h4').textContent
            };
        };
    }
}

// Aller à l'étape suivante
function nextStep() {
    if (checkCurrentStep()) {
        if (currentStep < 4) {
            // Cacher l'étape actuelle
            document.getElementById('step-' + currentStep).classList.remove('active');
            document.getElementById('step-indicator-' + currentStep).classList.remove('active');
            document.getElementById('step-indicator-' + currentStep).classList.add('completed');
            
            // Montrer l'étape suivante
            currentStep = currentStep + 1;
            document.getElementById('step-' + currentStep).classList.add('active');
            document.getElementById('step-indicator-' + currentStep).classList.add('active');
            
            // Changer les boutons
            updateButtons();
            
            // Si on arrive à l'étape 4, montrer le résumé
            if (currentStep == 4) {
                showSummary();
            }
        }
    }
}

// Revenir à l'étape précédente
function previousStep() {
    if (currentStep > 1) {
        // Cacher l'étape actuelle
        document.getElementById('step-' + currentStep).classList.remove('active');
        document.getElementById('step-indicator-' + currentStep).classList.remove('active');
        
        // Montrer l'étape précédente
        currentStep = currentStep - 1;
        document.getElementById('step-' + currentStep).classList.add('active');
        document.getElementById('step-indicator-' + currentStep).classList.remove('completed');
        document.getElementById('step-indicator-' + currentStep).classList.add('active');
        
        // Changer les boutons
        updateButtons();
    }
}

// Vérifier si l'étape actuelle est valide
function checkCurrentStep() {
    if (currentStep == 1) {
        if (!selectedService) {
            alert('Vous devez choisir un service.');
            return false;
        }
        return true;
    }
    
    if (currentStep == 2) {
        if (!selectedDate || !selectedTime) {
            alert('Vous devez choisir une date et une heure.');
            return false;
        }
        return true;
    }
    
    if (currentStep == 3) {
        var firstName = document.getElementById('firstName').value;
        var lastName = document.getElementById('lastName').value;
        var email = document.getElementById('email').value;
        var phone = document.getElementById('phone').value;
        
        if (firstName == '' || lastName == '' || email == '' || phone == '') {
            alert('Tous les champs obligatoires doivent être remplis.');
            return false;
        }
        
        // Vérification basique de l'email
        if (email.indexOf('@') == -1 || email.indexOf('.') == -1) {
            alert('Adresse email invalide.');
            return false;
        }
        
        return true;
    }
    
    if (currentStep == 4) {
        var terms = document.getElementById('terms');
        if (!terms.checked) {
            alert('Vous devez accepter les conditions.');
            return false;
        }
        return true;
    }
    
    return true;
}

// Mettre à jour les boutons selon l'étape
function updateButtons() {
    var prevBtn = document.getElementById('prevBtn');
    var nextBtn = document.getElementById('nextBtn');
    var submitBtn = document.getElementById('submitBtn');
    
    // Bouton précédent
    if (currentStep == 1) {
        prevBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'block';
    }
    
    // Bouton suivant ou valider
    if (currentStep == 4) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'block';
    } else {
        nextBtn.style.display = 'block';
        submitBtn.style.display = 'none';
    }
}

// Créer le calendrier (version simple)
function makeCalendar() {
    var calendar = document.getElementById('calendar');
    var monthSelect = document.getElementById('monthSelect');
    
    if (!calendar || !monthSelect) {
        return;
    }
    
    var selectedMonth = parseInt(monthSelect.value);
    var year = 2025;
    
    // Vider le calendrier
    calendar.innerHTML = '';
    
    // Ajouter les en-têtes des jours
    var days = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
    for (var d = 0; d < days.length; d++) {
        var dayHeader = document.createElement('div');
        dayHeader.className = 'calendar-day calendar-header';
        dayHeader.textContent = days[d];
        calendar.appendChild(dayHeader);
    }
    
    // Calculer le premier jour du mois et le nombre de jours
    var firstDay = new Date(year, selectedMonth, 1).getDay();
    var daysInMonth = new Date(year, selectedMonth + 1, 0).getDate();
    var today = new Date();
    
    // Ajouter des cases vides avant le premier jour
    for (var i = 0; i < firstDay; i++) {
        var emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day unavailable';
        calendar.appendChild(emptyDay);
    }
    
    // Ajouter tous les jours du mois
    for (var day = 1; day <= daysInMonth; day++) {
        var dayElement = document.createElement('div');
        dayElement.className = 'calendar-day';
        dayElement.textContent = day;
        
        var currentDate = new Date(year, selectedMonth, day);
        var isToday = currentDate.toDateString() == today.toDateString();
        var isPast = currentDate < today;
        var isSunday = currentDate.getDay() == 0; // Dimanche fermé
        
        if (isToday) {
            dayElement.classList.add('today');
        }
        
        if (isPast || isSunday) {
            dayElement.classList.add('unavailable');
        } else {
            // Ajouter l'événement click (version simple)
            dayElement.onclick = function() {
                selectDate(year, selectedMonth, parseInt(this.textContent), this);
            };
        }
        
        calendar.appendChild(dayElement);
    }
}

// Sélectionner une date
function selectDate(year, month, day, element) {
    // Enlever la sélection des autres jours
    var selectedDays = document.querySelectorAll('.calendar-day.selected');
    for (var i = 0; i < selectedDays.length; i++) {
        selectedDays[i].classList.remove('selected');
    }
    
    // Sélectionner le nouveau jour
    element.classList.add('selected');
    selectedDate = new Date(year, month, day);
    
    // Créer les créneaux horaires
    makeTimeSlots();
    
    // Montrer la section des créneaux
    document.getElementById('timeSlots').style.display = 'block';
}

// Créer les créneaux horaires
function makeTimeSlots() {
    var slotsContainer = document.getElementById('availableSlots');
    if (!slotsContainer || !selectedDate) {
        return;
    }
    
    slotsContainer.innerHTML = '';
    
    // Créneaux selon le jour de la semaine
    var timeSlots = [];
    var dayOfWeek = selectedDate.getDay();
    
    // Lundi à Jeudi
    if (dayOfWeek >= 1 && dayOfWeek <= 4) {
        timeSlots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                     '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30'];
    }
    // Vendredi
    else if (dayOfWeek == 5) {
        timeSlots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                     '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'];
    }
    // Samedi
    else if (dayOfWeek == 6) {
        timeSlots = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30'];
    }
    
    // Simuler quelques créneaux pris
    var takenSlots = [];
    // Prendre 2-3 créneaux au hasard comme occupés
    for (var i = 0; i < 2; i++) {
        var randomIndex = Math.floor(Math.random() * timeSlots.length);
        takenSlots.push(timeSlots[randomIndex]);
    }
    
    // Créer chaque créneau
    for (var t = 0; t < timeSlots.length; t++) {
        var time = timeSlots[t];
        var slotElement = document.createElement('div');
        slotElement.className = 'time-slot';
        slotElement.textContent = time;
        
        // Vérifier si ce créneau est pris
        var isTaken = false;
        for (var j = 0; j < takenSlots.length; j++) {
            if (takenSlots[j] == time) {
                isTaken = true;
                break;
            }
        }
        
        if (isTaken) {
            slotElement.classList.add('unavailable');
            slotElement.textContent = time + ' (Occupé)';
        } else {
            slotElement.onclick = function() {
                selectTimeSlot(this.textContent, this);
            };
        }
        
        slotsContainer.appendChild(slotElement);
    }
}

// Sélectionner un créneau horaire
function selectTimeSlot(time, element) {
    // Enlever la sélection des autres créneaux
    var selectedSlots = document.querySelectorAll('.time-slot.selected');
    for (var i = 0; i < selectedSlots.length; i++) {
        selectedSlots[i].classList.remove('selected');
    }
    
    // Sélectionner le nouveau créneau
    element.classList.add('selected');
    selectedTime = time;
}

// Afficher le résumé du rendez-vous
function showSummary() {
    var summaryContainer = document.getElementById('appointmentSummary');
    if (!summaryContainer) {
        return;
    }
    
    // Récupérer les informations du formulaire
    var firstName = document.getElementById('firstName').value;
    var lastName = document.getElementById('lastName').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var reason = document.getElementById('reason').value;
    var newPatient = document.getElementById('newPatient').checked;
    
    // Formater la date
    var dateStr = selectedDate.getDate() + '/' + (selectedDate.getMonth() + 1) + '/' + selectedDate.getFullYear();
    
    // Créer le contenu du résumé
    var summaryHTML = '';
    summaryHTML += '<div class="summary-item"><strong>Patient :</strong> <span>' + firstName + ' ' + lastName + '</span></div>';
    summaryHTML += '<div class="summary-item"><strong>Email :</strong> <span>' + email + '</span></div>';
    summaryHTML += '<div class="summary-item"><strong>Téléphone :</strong> <span>' + phone + '</span></div>';
    summaryHTML += '<div class="summary-item"><strong>Service :</strong> <span>' + selectedService.name + '</span></div>';
    summaryHTML += '<div class="summary-item"><strong>Date :</strong> <span>' + dateStr + '</span></div>';
    summaryHTML += '<div class="summary-item"><strong>Heure :</strong> <span>' + selectedTime + '</span></div>';
    summaryHTML += '<div class="summary-item"><strong>Durée :</strong> <span>' + selectedService.duration + ' minutes</span></div>';
    summaryHTML += '<div class="summary-item"><strong>Tarif :</strong> <span>' + selectedService.price + '€</span></div>';
    
    if (reason != '') {
        summaryHTML += '<div class="summary-item"><strong>Motif :</strong> <span>' + reason + '</span></div>';
    }
    
    if (newPatient) {
        summaryHTML += '<div class="summary-item"><strong>Statut :</strong> <span style="color: #4CAF50;">Nouveau patient</span></div>';
    }
    
    summaryContainer.innerHTML = summaryHTML;
}

// Envoyer le formulaire
function submitForm() {
    var appointmentForm = document.getElementById('appointmentForm');
    if (appointmentForm) {
        appointmentForm.onsubmit = function(e) {
            e.preventDefault();
            
            if (checkCurrentStep()) {
                sendAppointment();
            }
            return false;
        };
    }
}

// Envoyer le rendez-vous
function sendAppointment() {
    // Cacher le formulaire
    document.getElementById('step-4').classList.remove('active');
    document.getElementById('navigationButtons').style.display = 'none';
    var stepIndicator = document.querySelector('.step-indicator');
    if (stepIndicator) {
        stepIndicator.style.display = 'none';
    }
    
    // Montrer le message de succès
    document.getElementById('success-step').classList.add('active');
    
    // Log pour le développement
    console.log('Rendez-vous pris pour:', {
        service: selectedService,
        date: selectedDate,
        time: selectedTime
    });
}

// FAQ - Ouvrir/fermer les questions
function toggleFaq(element) {
    var answer = element.nextElementSibling;
    var icon = element.querySelector('span');
    
    if (answer.style.display == 'block') {
        answer.style.display = 'none';
        icon.textContent = '+';
    } else {
        // Fermer toutes les autres FAQ d'abord
        var allAnswers = document.querySelectorAll('.faq-answer');
        var allIcons = document.querySelectorAll('.faq-question span');
        for (var i = 0; i < allAnswers.length; i++) {
            allAnswers[i].style.display = 'none';
            allIcons[i].textContent = '+';
        }
        
        // Ouvrir celle cliquée
        answer.style.display = 'block';
        icon.textContent = '-';
    }
}

// Newsletter
function subscribeNewsletter(event) {
    event.preventDefault();
    var email = event.target.querySelector('input[type="email"]').value;
    
    // Vérification simple de l'email
    if (email.indexOf('@') > -1 && email.indexOf('.') > -1) {
        alert('Merci pour votre inscription !');
        event.target.reset();
    } else {
        alert('Email invalide.');
    }
}

// Autres fonctions utiles

// Fonction pour faire défiler vers une section
function scrollToSection(sectionId) {
    var section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

// Vérifier si on est en bas de page
function isAtBottom() {
    return window.innerHeight + window.scrollY >= document.body.offsetHeight;
}

// Au chargement de la page
window.onload = function() {
    // Initialiser le formulaire si nécessaire
    if (document.getElementById('appointmentForm')) {
        setupAppointmentForm();
        submitForm();
    }
    
    // Initialiser le calendrier
    if (document.getElementById('calendar')) {
        makeCalendar();
    }
};

// Smooth scrolling pour les ancres
document.querySelectorAll('a[href^=\"#\"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Effet de typed text pour le hero (optionnel)
function typeEffect(element, text, speed = 100) {
    let i = 0;
    element.innerHTML = '';
    
    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    
    type();
}

// Initialisation des tooltips (si nécessaire)
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.dataset.tooltip;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
        });
        
        element.addEventListener('mouseleave', function() {
            const tooltip = document.querySelector('.tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        });
    });
}

// Lazy loading des images (optimisation)
function lazyLoadImages() {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Gestion du mode sombre (optionnel)
function toggleTheme() {
    document.body.classList.toggle('dark-theme');
    localStorage.setItem('theme', document.body.classList.contains('dark-theme') ? 'dark' : 'light');
}

// Charger le thème sauvegardé
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-theme');
    }
});

// Gestion des cookies (conformité RGPD)
function showCookieConsent() {
    const cookieConsent = document.getElementById('cookie-consent');
    if (cookieConsent && !localStorage.getItem('cookieConsent')) {
        cookieConsent.style.display = 'block';
    }
}

function acceptCookies() {
    localStorage.setItem('cookieConsent', 'accepted');
    document.getElementById('cookie-consent').style.display = 'none';
}

// Initialisation finale
window.addEventListener('load', function() {
    // Toutes les fonctions d'initialisation
    initTooltips();
    lazyLoadImages();
    showCookieConsent();
    
    // Masquer le loader si présent
    const loader = document.querySelector('.loader');
    if (loader) {
        loader.style.display = 'none';
    }
});