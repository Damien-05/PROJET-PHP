<?php
use App\Utils\Auth;

if (!Auth::check() || Auth::isAdmin()) {
    redirect('/login');
}

$user = Auth::user();

// Récupérer le patient associé à l'utilisateur
$db = \App\Utils\Database::getInstance();
$patientModel = new \App\Models\Patient($db);
$patient = $patientModel->findByEmail($user['email']);

// Récupérer l'historique des rendez-vous
$appointmentModel = new \App\Models\Appointment($db);
$appointments = $patient ? $appointmentModel->getByPatient($patient['id']) : [];

$pageTitle = 'Mon Compte - Cabinet Dr. Dupont';
include __DIR__ . '/../layout/header.php';
?>

<section class="account-section">
    <div class="container">
        <div class="account-header">
            <h1>👤 Mon Compte</h1>
            <a href="<?= APP_URL ?>/logout" class="btn btn-secondary">Déconnexion</a>
        </div>
        
        <div class="account-grid">
            <!-- Informations personnelles -->
            <div class="account-card">
                <h2>Informations personnelles</h2>
                <?php if ($patient): ?>
                    <div class="info-group">
                        <span class="info-label">Nom complet</span>
                        <span class="info-value"><?= escape($patient['first_name'] . ' ' . $patient['last_name']) ?></span>
                    </div>
                    <div class="info-group">
                        <span class="info-label">Email</span>
                        <span class="info-value"><?= escape($patient['email']) ?></span>
                    </div>
                    <div class="info-group">
                        <span class="info-label">Téléphone</span>
                        <span class="info-value"><?= escape($patient['phone']) ?></span>
                    </div>
                    <div class="info-group">
                        <span class="info-label">Date de naissance</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($patient['date_of_birth'])) ?></span>
                    </div>
                    <div class="info-group">
                        <span class="info-label">Adresse</span>
                        <span class="info-value"><?= escape($patient['address']) ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Actions rapides -->
            <div class="account-card">
                <h2>Actions rapides</h2>
                <div class="quick-actions">
                    <a href="<?= APP_URL ?>/booking" class="action-btn">
                        <span class="action-icon">📅</span>
                        <span>Prendre un rendez-vous</span>
                    </a>
                    <a href="<?= APP_URL ?>/services" class="action-btn">
                        <span class="action-icon">🦷</span>
                        <span>Nos services</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Historique des rendez-vous -->
        <div class="account-card appointments-history">
            <h2>📋 Mes rendez-vous</h2>
            
            <?php if (empty($appointments)): ?>
                <div class="empty-state">
                    <p>Vous n'avez pas encore de rendez-vous.</p>
                    <a href="<?= APP_URL ?>/booking" class="btn btn-primary">Prendre un rendez-vous</a>
                </div>
            <?php else: ?>
                <div class="appointments-table-wrapper">
                    <table class="appointments-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Service</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $statusLabels = [
                                'pending' => 'En attente',
                                'confirmed' => 'Confirmé',
                                'cancelled' => 'Annulé',
                                'completed' => 'Terminé'
                            ];
                            foreach ($appointments as $appointment): 
                            ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($appointment['appointment_date'])) ?></td>
                                    <td><?= date('H:i', strtotime($appointment['appointment_time'])) ?></td>
                                    <td><?= escape($appointment['service_title']) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $appointment['status'] ?>">
                                            <?= $statusLabels[$appointment['status']] ?? $appointment['status'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>
