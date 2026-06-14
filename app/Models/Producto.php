<?php

class Producto
{
    public static function all(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT * FROM productos ORDER BY id'
        );
        return array_map([self::class, 'format'], $stmt->fetchAll());
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM productos WHERE id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::format($row) : null;
    }

    public static function findDestacados(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT * FROM productos WHERE destacado = 1 ORDER BY id'
        );
        return array_map([self::class, 'format'], $stmt->fetchAll());
    }

    public static function findByCategoria(string $categoria): array
    {
        $stmt = Database::getConnection()->prepare(
            'SELECT * FROM productos WHERE categoria = ? ORDER BY id'
        );
        $stmt->execute([$categoria]);
        return array_map([self::class, 'format'], $stmt->fetchAll());
    }

    private static function format(array $row): array
    {
        return [
            'id' => (int) $row['id'],
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'],
            'precio' => (float) $row['precio'],
            'imagen' => $row['imagen'],
            'destacado' => (bool) $row['destacado'],
            'categoria' => $row['categoria'],
            'etiqueta' => $row['etiqueta'],
        ];
    }
}
