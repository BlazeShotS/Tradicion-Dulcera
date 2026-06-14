<?php

class HistorialEntregasController extends Controller
{
    public function index(): void
    {
        $this->requireRole('admin');

        $this->render('dashboard/admin/historial-entregas', [
            'stats' => HistorialEntrega::stats(),
            'usuarios' => User::allByRole('mozo', 'admin'),
            'menuInternal' => $GLOBALS['menuInternal'],
        ], 'internal');
    }

    public function api(): void
    {
        $this->requireRole('admin');
        header('Content-Type: application/json');

        $result = HistorialEntrega::search(
            $_GET['q'] ?? null,
            $_GET['desde'] ?? null,
            $_GET['hasta'] ?? null,
            isset($_GET['entregado_por']) && $_GET['entregado_por'] !== '' ? (int) $_GET['entregado_por'] : null,
            (int) ($_GET['page'] ?? 1),
            20
        );

        echo json_encode($result);
    }

    public function detalle(): void
    {
        $this->requireRole('admin');
        header('Content-Type: application/json');

        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['error' => 'ID inválido']);
            return;
        }

        $item = HistorialEntrega::findById($id);
        if (!$item) {
            echo json_encode(['error' => 'No encontrado']);
            return;
        }

        echo json_encode($item);
    }
}
