<?php
$pageTitle = 'Dashboard - Administration';
require TEMPLATE_PATH . '/admin/layout/header.php';
?>

<div class="admin-container">
    <h2>Tableau de bord</h2>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Rendez-vous aujourd'hui</h3>
            <p class="stat-number"><?= count($todayAppointments) ?></p>
        </div>
        <div class="stat-card">
            <h3>Rendez-vous à venir</h3>
            <p class="stat-number"><?= count($upcomingAppointments) ?></p>
        </div>
    </div>

    <div class="dashboard-section">
        <h3>Rendez-vous du jour</h3>
        <?php if (empty($todayAppointments)): ?>
            <p class="no-content">Aucun rendez-vous aujourd'hui</p>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Heure</th>
                        <th>Patient</th>
                        <th>Service</th>
                        <th>Téléphone</th>
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
                    foreach ($todayAppointments as $appointment): 
                    ?>
                        <tr>
                            <td data-label="Heure"><?= date('H:i', strtotime($appointment['appointment_time'])) ?></td>
                            <td data-label="Patient"><?= escape($appointment['first_name'] . ' ' . $appointment['last_name']) ?></td>
                            <td data-label="Service"><?= escape($appointment['service_title']) ?></td>
                            <td data-label="Téléphone"><?= escape($appointment['phone']) ?></td>
                            <td data-label="Statut"><span class="badge badge-<?= $appointment['status'] ?>"><?= $statusLabels[$appointment['status']] ?? $appointment['status'] ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="dashboard-section">
        <h3>Prochains rendez-vous</h3>
        <?php if (empty($upcomingAppointments)): ?>
            <p class="no-content">Aucun rendez-vous à venir</p>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Patient</th>
                        <th>Service</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($upcomingAppointments, 0, 10) as $appointment): ?>
                        <tr>
                            <td data-label="Date"><?= date('d/m/Y', strtotime($appointment['appointment_date'])) ?></td>
                            <td data-label="Heure"><?= date('H:i', strtotime($appointment['appointment_time'])) ?></td>
                            <td data-label="Patient"><?= escape($appointment['first_name'] . ' ' . $appointment['last_name']) ?></td>
                            <td data-label="Service"><?= escape($appointment['service_title']) ?></td>
                            <td data-label="Statut"><span class="badge badge-<?= $appointment['status'] ?>"><?= $statusLabels[$appointment['status']] ?? $appointment['status'] ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="<?= APP_URL ?>/admin/appointments" class="btn btn-secondary">Voir tous les rendez-vous</a>
        <?php endif; ?>
    </div>
</div>

<?php require TEMPLATE_PATH . '/admin/layout/footer.php'; ?>
