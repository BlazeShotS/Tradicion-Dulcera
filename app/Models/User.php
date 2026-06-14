<?php

class User
{
    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM usuarios WHERE email = ? LIMIT 1'
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function allByRole(string ...$roles): array
    {
        if (empty($roles)) return [];

        $placeholders = implode(',', array_fill(0, count($roles), '?'));
        $stmt = Database::getConnection()->prepare(
            "SELECT id, nombre, email, rol FROM usuarios WHERE rol IN ($placeholders) ORDER BY nombre"
        );
        $stmt->execute($roles);
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM usuarios WHERE id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO usuarios (nombre, email, password, telefono, rol) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['nombre'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['telefono'] ?? '',
            $data['rol'] ?? 'mozo',
        ]);
        return (int) Database::getConnection()->lastInsertId();
    }
}
