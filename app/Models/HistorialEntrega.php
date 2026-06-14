<?php

class HistorialEntrega
{
    public static function search(?string $q, ?string $desde, ?string $hasta, ?int $userId, int $page = 1, int $perPage = 20): array
    {
        $conn = Database::getConnection();
        $where = [];
        $params = [];

        if ($q) {
            $where[] = '(c.cliente LIKE ? OR c.id = ?)';
            $params[] = "%$q%";
            $params[] = is_numeric($q) ? (int)$q : 0;
        }
        if ($desde) {
            $where[] = 'h.entregado_at >= ?';
            $params[] = $desde . ' 00:00:00';
        }
        if ($hasta) {
            $where[] = 'h.entregado_at <= ?';
            $params[] = $hasta . ' 23:59:59';
        }
        if ($userId) {
            $where[] = 'h.entregado_por = ?';
            $params[] = $userId;
        }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $countStmt = $conn->prepare(
            "SELECT COUNT(*) FROM historial_entregas h
             JOIN comandas c ON h.comanda_id = c.id
             $whereClause"
        );
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $offset = ($page - 1) * $perPage;
        $stmt = $conn->prepare(
            "SELECT h.*, u.nombre AS entregado_por_nombre,
                    c.mesa, c.cliente, c.total, c.vip, c.created_at AS comanda_creada
             FROM historial_entregas h
             LEFT JOIN usuarios u ON h.entregado_por = u.id
             JOIN comandas c ON h.comanda_id = c.id
             $whereClause
             ORDER BY h.entregado_at DESC
             LIMIT ? OFFSET ?"
        );
        $allParams = array_merge($params, [$perPage, $offset]);
        $stmt->execute($allParams);
        $rows = $stmt->fetchAll();

        $items = [];
        $itemStmt = $conn->prepare('SELECT * FROM comanda_items WHERE comanda_id = ? ORDER BY id');
        foreach ($rows as &$row) {
            $itemStmt->execute([$row['comanda_id']]);
            $row['items'] = $itemStmt->fetchAll();
            $items[] = $row;
        }

        return [
            'data' => $rows,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'lastPage' => max(1, (int) ceil($total / $perPage)),
        ];
    }

    public static function create(int $comandaId, int $userId, ?string $observaciones = null): int
    {
        $stmt = Database::getConnection()->prepare(
            'INSERT INTO historial_entregas (comanda_id, entregado_por, observaciones) VALUES (?, ?, ?)'
        );
        $stmt->execute([$comandaId, $userId, $observaciones]);
        return (int) Database::getConnection()->lastInsertId();
    }

    public static function stats(): array
    {
        try {
            $conn = Database::getConnection();

            $hoyStmt = $conn->query(
                "SELECT COUNT(*) AS total, COALESCE(SUM(c.total), 0) AS ingresos
                 FROM historial_entregas h
                 JOIN comandas c ON h.comanda_id = c.id
                 WHERE DATE(h.entregado_at) = CURDATE()"
            );
            $hoy = $hoyStmt ? $hoyStmt->fetch() : false;

            $semana = 0;
            $semStmt = $conn->query(
                "SELECT COUNT(*) AS total
                 FROM historial_entregas
                 WHERE YEARWEEK(entregado_at, 1) = YEARWEEK(CURDATE(), 1)"
            );
            if ($semStmt) $semana = (int) $semStmt->fetchColumn();

            $topMozo = null;
            $topStmt = $conn->query(
                "SELECT u.nombre, COUNT(*) AS total
                 FROM historial_entregas h
                 JOIN usuarios u ON h.entregado_por = u.id
                 WHERE h.entregado_por IS NOT NULL
                 GROUP BY h.entregado_por
                 ORDER BY total DESC
                 LIMIT 1"
            );
            if ($topStmt) $topMozo = $topStmt->fetch();

            $avgTime = 0;
            $avgStmt = $conn->query(
                "SELECT COALESCE(AVG(TIMESTAMPDIFF(MINUTE, c.created_at, h.entregado_at)), 0)
                 FROM historial_entregas h
                 JOIN comandas c ON h.comanda_id = c.id"
            );
            if ($avgStmt) $avgTime = (float) $avgStmt->fetchColumn();

            return [
                'hoy' => [
                    'total' => $hoy ? (int) ($hoy['total'] ?? 0) : 0,
                    'ingresos' => $hoy ? (float) ($hoy['ingresos'] ?? 0) : 0.0,
                ],
                'semana' => $semana,
                'topMozo' => $topMozo ? ['nombre' => $topMozo['nombre'] ?? '', 'total' => (int) ($topMozo['total'] ?? 0)] : null,
                'tiempoPromedio' => round($avgTime),
            ];
        } catch (\Throwable $e) {
            return [
                'hoy' => ['total' => 0, 'ingresos' => 0.0],
                'semana' => 0,
                'topMozo' => null,
                'tiempoPromedio' => 0,
            ];
        }
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT h.*, u.nombre AS entregado_por_nombre,
                    c.mesa, c.cliente, c.total, c.vip, c.tiempo, c.created_at AS comanda_creada
             FROM historial_entregas h
             LEFT JOIN usuarios u ON h.entregado_por = u.id
             JOIN comandas c ON h.comanda_id = c.id
             WHERE h.id = ?"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        $itemStmt = Database::getConnection()->prepare(
            'SELECT * FROM comanda_items WHERE comanda_id = ? ORDER BY id'
        );
        $itemStmt->execute([$row['comanda_id']]);
        $row['items'] = $itemStmt->fetchAll();

        return $row;
    }
}
