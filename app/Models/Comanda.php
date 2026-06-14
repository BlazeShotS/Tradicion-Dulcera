<?php

class Comanda
{
    public static function all(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT * FROM comandas ORDER BY id'
        );
        return array_map([self::class, 'format'], $stmt->fetchAll());
    }

    public static function findPendientes(): array
    {
        $stmt = Database::getConnection()->query(
            "SELECT * FROM comandas WHERE estado = 'pendiente' ORDER BY id"
        );
        return array_map([self::class, 'format'], $stmt->fetchAll());
    }

    public static function findEnPreparacion(): array
    {
        $stmt = Database::getConnection()->query(
            "SELECT * FROM comandas WHERE estado = 'preparacion' ORDER BY id"
        );
        return array_map([self::class, 'format'], $stmt->fetchAll());
    }

    public static function findListos(): array
    {
        $stmt = Database::getConnection()->query(
            "SELECT * FROM comandas WHERE estado = 'listo' ORDER BY id"
        );
        return array_map([self::class, 'format'], $stmt->fetchAll());
    }

    public static function findByUser(int $usuarioId): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM comandas WHERE usuario_id = ? ORDER BY id DESC'
        );
        $stmt->execute([$usuarioId]);
        return array_map([self::class, 'format'], $stmt->fetchAll());
    }

    public static function create(array $data, array $items): int
    {
        $conn = Database::getConnection();
        $conn->beginTransaction();

        $stmt = $conn->prepare(
            'INSERT INTO comandas (mesa, cliente, tiempo, vip, estado, usuario_id, total)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['mesa'] ?? 0,
            $data['cliente'] ?? '',
            0,
            0,
            'pendiente',
            $data['usuario_id'] ?? null,
            $data['total'] ?? 0.00,
        ]);
        $comandaId = (int) $conn->lastInsertId();

        $stmt = $conn->prepare(
            'INSERT INTO comanda_items (comanda_id, nombre, cantidad, variante) VALUES (?, ?, ?, ?)'
        );
        foreach ($items as $item) {
            $stmt->execute([
                $comandaId,
                $item['nombre'] ?? '',
                $item['cantidad'] ?? 1,
                $item['variante'] ?? null,
            ]);
        }

        $conn->commit();
        return $comandaId;
    }

    private static function format(array $row): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM comanda_items WHERE comanda_id = ? ORDER BY id'
        );
        $stmt->execute([$row['id']]);
        $items = $stmt->fetchAll();

        return [
            'id' => (int) $row['id'],
            'mesa' => (int) $row['mesa'],
            'cliente' => $row['cliente'],
            'items' => $items,
            'tiempo' => (int) $row['tiempo'],
            'vip' => (bool) $row['vip'],
            'estado' => $row['estado'],
            'usuario_id' => $row['usuario_id'] ? (int) $row['usuario_id'] : null,
            'total' => (float) ($row['total'] ?? 0),
            'created_at' => $row['created_at'] ?? '',
        ];
    }
}
