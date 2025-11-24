<?php
$pageTitle = 'Rendez-vous - Administration';
require TEMPLATE_PATH . '/admin/layout/header.php';
?>

<div class="admin-container">
    <h2>Gestion des rendez-vous</h2>

    <?php if (empty($appointments)): ?>
        <p class="no-content">Aucun rendez-vous à venir</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Patient</th>
                    <th>Téléphone</th>
                    <th>Service</th>
                    <th>Statut</th>
                    <th>Actions</th>
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
                        <td><?= escape($appointment['first_name'] . ' ' . $appointment['last_name']) ?></td>
                        <td><?= escape($appointment['phone']) ?></td>
                        <td><?= escape($appointment['service_title']) ?></td>
                        <td><span class="badge badge-<?= $appointment['status'] ?>"><?= $statusLabels[$appointment['status']] ?? $appointment['status'] ?></span></td>
                        <td>
                            <form method="POST" action="<?= APP_URL ?>/admin/appointments/update-status" style="display: inline-block;">
                                <input type="hidden" name="id" value="<?= $appointment['id'] ?>">
                                <select name="status" onchange="this.form.submit()" class="status-select">
                                    <option value="pending" <?= $appointment['status'] === 'pending' ? 'selected' : '' ?>>En attente</option>
                                    <option value="confirmed" <?= $appointment['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmé</option>
                                    <option value="completed" <?= $appointment['status'] === 'completed' ? 'selected' : '' ?>>Terminé</option>
                                    <option value="cancelled" <?= $appointment['status'] === 'cancelled' ? 'selected' : '' ?>>Annulé</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require TEMPLATE_PATH . '/admin/layout/footer.php'; ?>
