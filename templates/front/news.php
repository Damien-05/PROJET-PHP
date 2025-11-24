<?php
$pageTitle = 'Actualités - Cabinet Dr. Dupont';
require TEMPLATE_PATH . '/layout/header.php';
?>

<section class="page-header">
    <div class="container">
        <h2>Actualités</h2>
        <p>Restez informé des dernières nouvelles du cabinet</p>
    </div>
</section>

<section class="news-list">
    <div class="container">
        <?php if (empty($news)): ?>
            <p class="no-content">Aucune actualité pour le moment.</p>
        <?php else: ?>
            <div class="news-grid-modern">
                <?php foreach ($news as $article): 
                    // Générer une image aléatoire pour chaque article
                    $newsImages = [
                        'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=600&h=400&fit=crop&q=80',
                        'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=600&h=400&fit=crop&q=80',
                        'https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=600&h=400&fit=crop&q=80',
                        'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?w=600&h=400&fit=crop&q=80'
                    ];
                    $imageIndex = $article['id'] % count($newsImages);
                    $articleImage = $newsImages[$imageIndex];
                ?>
                    <article class="news-card-modern">
                        <div class="news-image-wrapper">
                            <img src="<?= $articleImage ?>" alt="<?= escape($article['title']) ?>" class="news-card-image">
                            <div class="news-date-badge">
                                <span class="date-day"><?= date('d', strtotime($article['published_at'])) ?></span>
                                <span class="date-month"><?= date('M', strtotime($article['published_at'])) ?></span>
                            </div>
                        </div>
                        <div class="news-card-content">
                            <h3 class="news-card-title"><?= escape($article['title']) ?></h3>
                            <?php if (!empty($article['author_name'])): ?>
                                <p class="news-author-info">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Par <?= escape($article['author_name']) ?>
                                </p>
                            <?php endif; ?>
                            <p class="news-card-excerpt"><?= escape($article['excerpt'] ?? substr($article['content'], 0, 150)) ?>...</p>
                            <a href="<?= APP_URL ?>/news/<?= $article['id'] ?>" class="btn-news-read">
                                <span>Lire la suite</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require TEMPLATE_PATH . '/layout/footer.php'; ?>
