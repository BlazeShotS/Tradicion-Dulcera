<?php

class CocinaController extends Controller
{
    public function index(): void
    {
        $this->requireRole('admin', 'cocina');

        $comandasCocina = Comanda::findEnPreparacion();

        $this->render('dashboard/cocina', [
            'comandasCocina' => $comandasCocina,
            'menuInternal' => $GLOBALS['menuInternal'],
        ], 'internal');
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
