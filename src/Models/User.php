<?php

namespace App\Models;

class User
{
    public static function findByEmail(string $email): ?array
    {
        $stmt = db()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        return $stmt->fetch() ?: null;
    }

public static function create(array $data): void
{
    $stmt = db()->prepare("
        INSERT INTO users (name, email, password)
        VALUES (:name, :email, :password)
    ");

    $stmt->execute([
        ':name' => $data['name'],
        ':email' => $data['email'],
        ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
    ]);
}
}