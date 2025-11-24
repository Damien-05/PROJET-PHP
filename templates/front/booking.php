<?php
$pageTitle = 'Prendre rendez-vous - Cabinet Dr. Dupont';
require TEMPLATE_PATH . '/layout/header.php';
?>

<section class="page-header">
    <div class="container">
        <h2>Prendre rendez-vous</h2>
        <p>Remplissez le formulaire ci-dessous pour réserver votre créneau</p>
    </div>
</section>

<section class="booking-form">
    <div class="container">
        <?php if ($success): ?>
            <div class="alert alert-success">
                <h3>✅ Rendez-vous confirmé !</h3>
                <p>Votre demande de rendez-vous a été enregistrée avec succès. Vous recevrez une confirmation par email.</p>
                <a href="<?= APP_URL ?>/" class="btn btn-primary">Retour à l'accueil</a>
            </div>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <h4>⚠️ Erreurs dans le formulaire :</h4>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= escape($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= APP_URL ?>/booking" class="form">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

                <div class="form-section">
                    <h3>Vos informations</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">Prénom <span class="required">*</span></label>
                            <input type="text" id="first_name" name="first_name" 
                                   value="<?= escape($_POST['first_name'] ?? $patientInfo['first_name'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">Nom <span class="required">*</span></label>
                            <input type="text" id="last_name" name="last_name" 
                                   value="<?= escape($_POST['last_name'] ?? $patientInfo['last_name'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" 
                                   value="<?= escape($_POST['email'] ?? $patientInfo['email'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Téléphone <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" 
                                   value="<?= escape($_POST['phone'] ?? $patientInfo['phone'] ?? '') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Détails du rendez-vous</h3>
                    
                    <div class="form-group">
                        <label for="service_id">Service souhaité <span class="required">*</span></label>
                        <select id="service_id" name="service_id" required>
                            <option value="">-- Sélectionnez un service --</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= $service['id'] ?>" 
                                        <?= (($_POST['service_id'] ?? '') == $service['id']) ? 'selected' : '' ?>>
                                    <?= escape($service['title']) ?> 
                                    (<?= $service['duration'] ?> min - <?= number_format($service['price'], 2) ?>€)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="appointment_date">Date <span class="required">*</span></label>
                            <input type="date" id="appointment_date" name="appointment_date" 
                                   min="<?= date('Y-m-d') ?>"
                                   value="<?= escape($_POST['appointment_date'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="appointment_time">Heure <span class="required">*</span></label>
                            <select id="appointment_time" name="appointment_time" required>
                                <option value="">-- Choisissez d'abord une date --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Informations complémentaires</label>
                        <textarea id="notes" name="notes" rows="4"><?= escape($_POST['notes'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">Confirmer le rendez-vous</button>
                </div>
            </form>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dateInput = document.getElementById('appointment_date');
                const serviceInput = document.getElementById('service_id');
                const timeSelect = document.getElementById('appointment_time');

                function loadAvailableSlots() {
                    const date = dateInput.value;
                    const serviceId = serviceInput.value;

                    if (!date || !serviceId) {
                        timeSelect.innerHTML = '<option value="">-- Veuillez sélectionner une date et un service --</option>';
                        return;
                    }

                    timeSelect.innerHTML = '<option value="">Chargement...</option>';

                    fetch(`<?= APP_URL ?>/api/available-slots?date=${date}&service_id=${serviceId}`)
                        .then(response => response.json())
                        .then(data => {
                            timeSelect.innerHTML = '';
                            
                            if (data.slots && data.slots.length > 0) {
                                data.slots.forEach(slot => {
                                    const option = document.createElement('option');
                                    option.value = slot + ':00';
                                    option.textContent = slot;
                                    timeSelect.appendChild(option);
                                });
                            } else {
                                timeSelect.innerHTML = '<option value="">Aucun créneau disponible</option>';
                            }
                        })
                        .catch(error => {
                            timeSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                        });
                }

                dateInput.addEventListener('change', loadAvailableSlots);
                serviceInput.addEventListener('change', loadAvailableSlots);
            });
            </script>
        <?php endif; ?>
    </div>
</section>

<?php require TEMPLATE_PATH . '/layout/footer.php'; ?>
