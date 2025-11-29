<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Models\News;
use App\Utils\Database;

class NewsApiController
{
    private News $newsModel;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->newsModel = new News($db);
    }

    /**
     * GET /api/news
     * Retourne la liste des actualités publiées en JSON
     */
    public function list(): void
    {
        header('Content-Type: application/json');
        
        try {
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
            $news = $this->newsModel->findPublished($limit);
            
            // Formatage pour l'API
            $response = array_map(function($article) {
                return [
                    'id' => $article['id'],
                    'title' => $article['title'],
                    'excerpt' => $article['excerpt'],
                    'content' => $article['content'],
                    'image' => $article['image'],
                    'author' => $article['author_name'] ?? 'N/A',
                    'published_at' => $article['published_at'],
                    'created_at' => $article['created_at']
                ];
            }, $news);
            
            echo json_encode([
                'success' => true,
                'data' => $response,
                'count' => count($response)
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Internal server error'
            ]);
        }
    }

    /**
     * GET /api/news/{id}
     * Retourne le détail d'une actualité en JSON
     */
    public function show(int $id): void
    {
        header('Content-Type: application/json');
        
        try {
            $article = $this->newsModel->findById($id);
            
            if (!$article || !$article['is_published']) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'error' => 'News not found'
                ]);
                return;
            }
            
            // Formatage pour l'API
            $response = [
                'id' => $article['id'],
                'title' => $article['title'],
                'excerpt' => $article['excerpt'],
                'content' => $article['content'],
                'image' => $article['image'],
                'author' => $article['author_name'] ?? 'N/A',
                'published_at' => $article['published_at'],
                'created_at' => $article['created_at']
            ];
            
            echo json_encode([
                'success' => true,
                'data' => $response
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Internal server error'
            ]);
        }
    }
}
