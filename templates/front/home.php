<?php
$pageTitle = 'Accueil - Cabinet Dr. Dupont';
$metaDescription = 'Cabinet dentaire du Dr. Dupont. Prenez rendez-vous en ligne pour vos soins dentaires.';
require TEMPLATE_PATH . '/layout/header.php';
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h2>Bienvenue au Cabinet Dr. Dupont</h2>
            <p class="hero-subtitle">Des soins dentaires de qualité dans un environnement moderne et confortable</p>
            <a href="<?= APP_URL ?>/booking" class="btn btn-primary btn-large">Prendre rendez-vous</a>
        </div>
    </div>
</section>

<section class="services-preview">
    <div class="container">
        <h2>Nos Services</h2>
        <div class="services-grid">
            <?php 
            foreach (array_slice($services, 0, 6) as $service): 
                // Utiliser l'image de la BDD ou une image par défaut
                $image = $service['image'] ?? 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=400&h=300&fit=crop&q=80';
            ?>
                <div class="service-card">
                    <div class="service-card-image">
                        <img src="<?= $image ?>" alt="<?= escape($service['title']) ?>">
                    </div>
                    <h3><?= escape($service['title']) ?></h3>
                    <p><?= escape(substr($service['description'], 0, 100)) ?>...</p>
                    <p class="service-info">
                        <span>⏱️ <?= $service['duration'] ?> min</span>
                        <?php if ($service['price']): ?>
                            <span>💰 <?= number_format($service['price'], 2) ?>€</span>
                        <?php endif; ?>
                    </p>
                </div>
            <?php 
            endforeach; 
            ?>
        </div>
        <div class="text-center">
            <a href="<?= APP_URL ?>/services" class="btn btn-secondary">Voir tous les services</a>
        </div>
    </div>
</section>

<section class="about-preview">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2>Dr. Dupont</h2>
                <p>Diplômé de la Faculté de Médecine Dentaire de Paris, le Dr. Dupont exerce depuis plus de 15 ans. 
                   Passionné par son métier, il se consacre à offrir des soins de qualité dans un environnement 
                   accueillant et rassurant.</p>
                <p>Notre cabinet est équipé des dernières technologies pour vous garantir des traitements efficaces 
                   et confortables.</p>
                <a href="<?= APP_URL ?>/about" class="btn btn-secondary">En savoir plus</a>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=800&h=600&fit=crop&q=80" 
                     alt="Cabinet Dr. Dupont" 
                     style="border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.12); width: 100%; height: auto;">
            </div>
        </div>
    </div>
</section>

<?php if (!empty($news)): ?>
<section class="news-preview">
    <div class="container">
        <h2>Actualités</h2>
        <div class="news-grid-modern">
            <?php foreach ($news as $article): 
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
                        <p class="news-card-excerpt"><?= escape($article['excerpt'] ?? substr($article['content'], 0, 120)) ?>...</p>
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
        <div class="text-center" style="margin-top: 3rem;">
            <a href="<?= APP_URL ?>/news" class="btn btn-secondary">Toutes les actualités</a>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="cta">
    <div class="container">
        <h2>Prenez rendez-vous dès maintenant</h2>
        <p>Notre équipe est à votre disposition pour répondre à tous vos besoins en soins dentaires</p>
        <a href="<?= APP_URL ?>/booking" class="btn btn-primary btn-large">Réserver un créneau</a>
    </div>
</section>

<?php require TEMPLATE_PATH . '/layout/footer.php'; ?>
