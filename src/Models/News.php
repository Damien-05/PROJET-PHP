<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class News extends Model
{
    protected string $table = 'news';

    public function create(array $data): int
    {
        return $this->insert([
            'title' => $data['title'],
            'content' => $data['content'],
            'excerpt' => $data['excerpt'] ?? null,
            'author_id' => $data['author_id'] ?? null,
            'is_published' => $data['is_published'] ?? false,
            'published_at' => $data['published_at'] ?? null,
        ]);
    }

    public function updateNews(int $id, array $data): bool
    {
        return $this->update($id, [
            'title' => $data['title'],
            'content' => $data['content'],
            'excerpt' => $data['excerpt'] ?? null,
            'is_published' => $data['is_published'] ?? false,
            'published_at' => $data['published_at'] ?? null,
        ]);
    }

    public function findPublished(int $limit = 10): array
    {
        $stmt = $this->db->prepare(
            "SELECT n.*, u.name as author_name
             FROM {$this->table} n
             LEFT JOIN users u ON n.author_id = u.id
             WHERE n.is_published = 1 AND n.published_at <= NOW()
             ORDER BY n.published_at DESC
             LIMIT ?"
        );
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function publish(int $id): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET is_published = 1, published_at = NOW() WHERE id = ?"
        );
        return $stmt->execute([$id]);
    }

    public function unpublish(int $id): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET is_published = 0 WHERE id = ?"
        );
        return $stmt->execute([$id]);
    }
}
