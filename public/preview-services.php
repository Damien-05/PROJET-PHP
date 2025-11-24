<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu des services avec images</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        .card {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: white;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        .card-info {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e0e0e0;
        }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .badge-time {
            background: #e3f2fd;
            color: #1976d2;
        }
        .badge-price {
            background: #f3e5f5;
            color: #7b1fa2;
        }
        .badge-local {
            background: #e8f5e9;
            color: #388e3c;
        }
        .badge-unsplash {
            background: #fff3e0;
            color: #f57c00;
        }
        .stats {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            margin-bottom: 2rem;
        }
        .stats h2 {
            margin: 0;
            font-size: 3rem;
        }
        .stats p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🦷 Services du Cabinet Dentaire</h1>
        
        <?php
        require_once __DIR__ . '/../config/bootstrap.php';
        use App\Utils\Database;
        
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY display_order, id");
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $withImages = array_filter($services, fn($s) => !empty($s['image']));
        ?>
        
        <div class="stats">
            <h2><?= count($services) ?></h2>
            <p>Services disponibles avec <?= count($withImages) ?> images configurées</p>
        </div>
        
        <div class="grid">
            <?php foreach ($services as $service): 
                $imageType = empty($service['image']) ? 'none' : 
                    (strpos($service['image'], 'unsplash.com') !== false ? 'unsplash' : 'local');
            ?>
                <div class="card">
                    <img src="<?= $service['image'] ?? 'https://via.placeholder.com/400x300?text=Pas+d\'image' ?>" 
                         alt="<?= htmlspecialchars($service['title']) ?>">
                    <div class="card-body">
                        <div class="card-title"><?= htmlspecialchars($service['title']) ?></div>
                        <div class="card-info">
                            <span class="badge badge-time">⏱️ <?= $service['duration'] ?> min</span>
                            <span class="badge badge-price">💰 <?= number_format($service['price'], 2) ?>€</span>
                        </div>
                        <div style="margin-top: 1rem;">
                            <?php if ($imageType === 'local'): ?>
                                <span class="badge badge-local">📁 Image locale</span>
                            <?php elseif ($imageType === 'unsplash'): ?>
                                <span class="badge badge-unsplash">🌐 Unsplash</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
