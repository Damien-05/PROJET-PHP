<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class User extends Model
{
    protected string $table = 'users';

    public function create(array $data): int
    {
        return $this->insert([
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'name' => $data['name'],
            'role' => $data['role'] ?? 'staff',
        ]);
    }

    public function updateUser(int $id, array $data): bool
    {
        $updateData = [
            'email' => $data['email'],
            'name' => $data['name'],
            'role' => $data['role'] ?? 'staff',
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->update($id, $updateData);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function verifyCredentials(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        
        if (!$user || !$this->verifyPassword($password, $user['password'])) {
            return null;
        }
        
        return $user;
    }
}
