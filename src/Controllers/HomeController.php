<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Service;
use App\Models\News;
use App\Utils\Database;

class HomeController
{
    private Service $serviceModel;
    private News $newsModel;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->serviceModel = new Service($db);
        $this->newsModel = new News($db);
    }

    public function index(): void
    {
        $services = $this->serviceModel->findActive();
        $news = $this->newsModel->findPublished(3);
        
        require TEMPLATE_PATH . '/front/home.php';
    }

    public function services(): void
    {
        $services = $this->serviceModel->findActive();
        
        require TEMPLATE_PATH . '/front/services.php';
    }

    public function about(): void
    {
        require TEMPLATE_PATH . '/front/about.php';
    }

    public function news(): void
    {
        $news = $this->newsModel->findPublished(10);
        
        require TEMPLATE_PATH . '/front/news.php';
    }

    public function newsDetail(int $id): void
    {
        $article = $this->newsModel->findById($id);
        
        if (!$article || !$article['is_published']) {
            http_response_code(404);
            require TEMPLATE_PATH . '/errors/404.php';
            return;
        }
        
        require TEMPLATE_PATH . '/front/news-detail.php';
    }
}
