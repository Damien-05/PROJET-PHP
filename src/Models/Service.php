<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Service extends Model
{
    protected string $table = 'services';

    public function create(array $data): int
    {
        return $this->insert([
            'title' => $data['title'],
            'description' => $data['description'],
            'duration' => (int) $data['duration'],
            'price' => $data['price'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'display_order' => (int) ($data['display_order'] ?? 0),
        ]);
    }

    public function updateService(int $id, array $data): bool
    {
        return $this->update($id, [
            'title' => $data['title'],
            'description' => $data['description'],
            'duration' => (int) $data['duration'],
            'price' => $data['price'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'display_order' => (int) ($data['display_order'] ?? 0),
        ]);
    }

    public function findActive(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY display_order, title"
        );
        return $stmt->fetchAll();
    }

    public function toggleActive(int $id): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET is_active = NOT is_active WHERE id = ?"
        );
        return $stmt->execute([$id]);
    }
}
