<?php

class Pilar
{
    public static function all(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT * FROM pilares ORDER BY id'
        );
        return $stmt->fetchAll();
    }
}
