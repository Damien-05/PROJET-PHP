<?php
$pageTitle = 'Patients - Administration';
require TEMPLATE_PATH . '/admin/layout/header.php';
?>

<div class="admin-container">
    <h2>Gestion des patients</h2>

    <?php if (empty($patients)): ?>
        <p class="no-content">Aucun patient enregistré</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Date de naissance</th>
                    <th>Inscrit le</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= $patient['id'] ?></td>
                        <td><?= escape($patient['last_name']) ?></td>
                        <td><?= escape($patient['first_name']) ?></td>
                        <td><?= escape($patient['email']) ?></td>
                        <td><?= escape($patient['phone']) ?></td>
                        <td><?= $patient['date_of_birth'] ? date('d/m/Y', strtotime($patient['date_of_birth'])) : '-' ?></td>
                        <td><?= date('d/m/Y', strtotime($patient['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require TEMPLATE_PATH . '/admin/layout/footer.php'; ?>
