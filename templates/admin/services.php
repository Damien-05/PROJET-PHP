<?php
$pageTitle = 'Services - Administration';
require TEMPLATE_PATH . '/admin/layout/header.php';
?>

<div class="admin-container">
    <h2>Gestion des services</h2>

    <div class="admin-actions">
        <button onclick="document.getElementById('add-service-modal').style.display='block'" class="btn btn-primary">
            + Ajouter un service
        </button>
    </div>

    <?php if (empty($services)): ?>
        <p class="no-content">Aucun service disponible</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Durée (min)</th>
                    <th>Prix (€)</th>
                    <th>Ordre</th>
                    <th>Actif</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?= $service['id'] ?></td>
                        <td>
                            <?php if (!empty($service['image'])): ?>
                                <img src="<?= $service['image'] ?>" alt="<?= escape($service['title']) ?>">
                            <?php else: ?>
                                <span style="color: #999; font-style: italic;">Aucune</span>
                            <?php endif; ?>
                        </td>
                        <td><?= escape($service['title']) ?></td>
                        <td><?= $service['duration'] ?></td>
                        <td><?= number_format($service['price'], 2) ?></td>
                        <td><?= $service['display_order'] ?></td>
                        <td><?= $service['is_active'] ? '✅' : '❌' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Modal Ajout Service -->
<div id="add-service-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('add-service-modal').style.display='none'">&times;</span>
        <h3>Ajouter un nouveau service</h3>
        
        <form method="POST" action="<?= APP_URL ?>/admin/services/create" enctype="multipart/form-data" class="form">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image du service</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg">
                <small style="color: #666;">Format accepté : JPG, JPEG, PNG (Max 2MB)</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="duration">Durée (minutes)</label>
                    <input type="number" id="duration" name="duration" required>
                </div>

                <div class="form-group">
                    <label for="price">Prix (€)</label>
                    <input type="number" step="0.01" id="price" name="price" required>
                </div>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" checked>
                    Service actif
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Créer le service</button>
        </form>
    </div>
</div>

<?php require TEMPLATE_PATH . '/admin/layout/footer.php'; ?>
