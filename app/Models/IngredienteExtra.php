<?php

class IngredienteExtra
{
    public static function all(): array
    {
        $stmt = Database::getConnection()->query(
            'SELECT * FROM ingredientes_extra ORDER BY id'
        );
        return $stmt->fetchAll();
    }
}
