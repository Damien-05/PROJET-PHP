<?php
$pageTitle = 'Actualités - Administration';
require TEMPLATE_PATH . '/admin/layout/header.php';
?>

<div class="admin-container">
    <h2>Gestion des actualités</h2>

    <div class="admin-actions">
        <button onclick="document.getElementById('add-news-modal').style.display='block'" class="btn btn-primary">
            + Ajouter une actualité
        </button>
    </div>

    <?php if (empty($news)): ?>
        <p class="no-content">Aucune actualité</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Date de publication</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news as $article): ?>
                    <tr>
                        <td><?= $article['id'] ?></td>
                        <td><?= escape($article['title']) ?></td>
                        <td><?= escape($article['author_name'] ?? 'N/A') ?></td>
                        <td><?= $article['published_at'] ? date('d/m/Y H:i', strtotime($article['published_at'])) : '-' ?></td>
                        <td><?= $article['is_published'] ? '✅ Publié' : '📝 Brouillon' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Modal Ajout Actualité -->
<div id="add-news-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('add-news-modal').style.display='none'">&times;</span>
        <h3>Ajouter une nouvelle actualité</h3>
        
        <form method="POST" action="<?= APP_URL ?>/admin/news/create" class="form">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="excerpt">Extrait (résumé court)</label>
                <textarea id="excerpt" name="excerpt" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label for="content">Contenu</label>
                <textarea id="content" name="content" rows="8" required></textarea>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_published">
                    Publier immédiatement
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Créer l'actualité</button>
        </form>
    </div>
</div>

<?php require TEMPLATE_PATH . '/admin/layout/footer.php'; ?>
