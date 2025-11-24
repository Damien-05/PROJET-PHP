<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Patient extends Model
{
    protected string $table = 'patients';

    public function create(array $data): int
    {
        return $this->insert([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'gender' => $data['gender'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
    }

    public function updatePatient(int $id, array $data): bool
    {
        return $this->update($id, [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function search(string $query): array
    {
        $searchTerm = "%{$query}%";
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} 
             WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ? 
             ORDER BY last_name, first_name"
        );
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
}
