<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Schedule extends Model
{
    protected string $table = 'schedules';

    public function updateSchedule(int $id, array $data): bool
    {
        return $this->update($id, [
            'opening_time' => $data['opening_time'],
            'closing_time' => $data['closing_time'],
            'is_closed' => $data['is_closed'] ?? false,
        ]);
    }

    public function findByDay(string $day): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE day_of_week = ?");
        $stmt->execute([$day]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function getOpenDays(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table} WHERE is_closed = 0 ORDER BY FIELD(day_of_week, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche')"
        );
        return $stmt->fetchAll();
    }
}
