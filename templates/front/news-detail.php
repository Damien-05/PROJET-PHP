<?php
$pageTitle = escape($article['title']) . ' - Cabinet Dr. Dupont';
require TEMPLATE_PATH . '/layout/header.php';
?>

<section class="page-header">
    <div class="container">
        <a href="<?= APP_URL ?>/news" class="back-link">← Retour aux actualités</a>
    </div>
</section>

<article class="news-detail">
    <div class="container">
        <header class="news-detail-header">
            <h2><?= escape($article['title']) ?></h2>
            <p class="news-meta">
                <span class="news-date">📅 <?= date('d/m/Y à H:i', strtotime($article['published_at'])) ?></span>
                <?php if (!empty($article['author_name'])): ?>
                    <span class="news-author">✍️ Par <?= escape($article['author_name']) ?></span>
                <?php endif; ?>
            </p>
        </header>

        <div class="news-content">
            <?= nl2br(escape($article['content'])) ?>
        </div>

        <footer class="news-detail-footer">
            <a href="<?= APP_URL ?>/news" class="btn btn-secondary">← Retour aux actualités</a>
        </footer>
    </div>
</article>

<?php require TEMPLATE_PATH . '/layout/footer.php'; ?>
