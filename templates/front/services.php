<?php
$pageTitle = 'Nos Services - Cabinet Dr. Dupont';
require TEMPLATE_PATH . '/layout/header.php';
?>

<section class="page-header">
    <div class="container">
        <h2>Nos Services</h2>
        <p>Découvrez nos prestations dentaires sur mesure avec les dernières technologies</p>
    </div>
</section>

<section class="services-detail">
    <div class="container">
        <div class="services-grid-modern">
            <?php 
            foreach ($services as $service): 
                // Utiliser l'image de la BDD ou une image par défaut
                $image = $service['image'] ?? 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=400&h=300&fit=crop&q=80';
            ?>
                <article class="service-detail-card-modern">
                    <div class="service-image-wrapper">
                        <img src="<?= $image ?>" alt="<?= escape($service['title']) ?>" class="service-detail-image">
                        <div class="service-overlay">
                            <div class="service-overlay-content">
                                <h3><?= escape($service['title']) ?></h3>
                                <div class="service-meta-overlay">
                                    <span class="badge-overlay"><i class="icon-time">⏱</i> <?= $service['duration'] ?> min</span>
                                    <?php if ($service['price']): ?>
                                        <span class="badge-overlay badge-price-overlay"><i class="icon-price">💰</i> <?= number_format($service['price'], 2) ?>€</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="service-content">
                        <p class="service-description"><?= nl2br(escape($service['description'])) ?></p>
                        <a href="<?= APP_URL ?>/booking?service=<?= $service['id'] ?>" class="btn-service-book">
                            <span>Prendre rendez-vous</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Une question sur nos services ?</h2>
        <p>N'hésitez pas à nous contacter pour plus d'informations</p>
        <a href="<?= APP_URL ?>/booking" class="btn btn-primary btn-large">Prendre rendez-vous</a>
    </div>
</section>

<?php require TEMPLATE_PATH . '/layout/footer.php'; ?>
