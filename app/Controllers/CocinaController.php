<?php

class CocinaController extends Controller
{
    public function index(): void
    {
        $this->requireRole('admin', 'cocina');

        $comandasCocina = Comanda::findEnPreparacion();

        // meta del día (configurable por sesión)
        $meta = (int) ($_SESSION['meta_dia'] ?? 60);
        if ($meta <= 0) {
            $meta = 60;
        }

        // usar entregas del día (historial_entregas) para medir 'cumplimiento' de la meta
        $deliveredToday = HistorialEntrega::countToday();
        $ocupacion = $meta > 0 ? min(100, (int) round($deliveredToday / $meta * 100)) : 0;

        $this->render('dashboard/cocina', [
            'comandasCocina' => $comandasCocina,
            'menuInternal' => $GLOBALS['menuInternal'],
            'ocupacion' => $ocupacion,
            'meta_dia' => $meta,
            'delivered_today' => $deliveredToday,
        ], 'internal');
    }

    public function setMeta(): void
    {
        $this->requireRole('admin', 'cocina');

        $meta = (int) ($_POST['meta_dia'] ?? 0);
        if ($meta > 0) {
            $_SESSION['meta_dia'] = $meta;
        } else {
            unset($_SESSION['meta_dia']);
        }

        $this->redirect('/cocina');
    }

    public function marcarListo(): void
    {
        $this->requireRole('admin', 'cocina');

        $id = (int) ($_POST['comanda_id'] ?? 0);
        if ($id <= 0) {
            $this->redirect('/cocina');
            return;
        }

        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE comandas SET estado = 'listo' WHERE id = ? AND estado = 'preparacion'");
        $stmt->execute([$id]);

        $this->redirect('/cocina');
    }
}
