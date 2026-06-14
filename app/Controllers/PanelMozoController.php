<?php

class PanelMozoController extends Controller
{
    public function index(): void
    {
        $this->requireRole('admin', 'mozo');

        $comandasPendientes = Comanda::findPendientes();

        $this->render('dashboard/panel-mozo', [
            'comandasPendientes' => $comandasPendientes,
            'menuInternal' => $GLOBALS['menuInternal'],
        ], 'internal');
    }

    public function moverPreparacion(): void
    {
        $this->requireRole('admin', 'mozo');

        $id = (int) ($_POST['comanda_id'] ?? 0);
        if ($id <= 0) {
            $this->redirect('/panel-mozo');
            return;
        }

        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE comandas SET estado = 'preparacion' WHERE id = ? AND estado = 'pendiente'");
        $stmt->execute([$id]);

        $this->redirect('/panel-mozo');
    }
}
