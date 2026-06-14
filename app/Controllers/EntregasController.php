<?php

class EntregasController extends Controller
{
    public function index(): void
    {
        $this->requireRole('admin', 'mozo');

        $comandasListas = Comanda::findListos();

        $this->render('dashboard/entregas', [
            'comandasListas' => $comandasListas,
            'menuInternal' => $GLOBALS['menuInternal'],
        ], 'internal');
    }

    public function confirmarEntrega(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/entregas');
            return;
        }

        $this->requireRole('admin', 'mozo');

        $id = (int) ($_POST['comanda_id'] ?? 0);
        if ($id <= 0) {
            $this->redirect('/entregas');
            return;
        }

        $user = Auth::user();
        $observaciones = $_POST['observaciones'] ?? null;

        $conn = Database::getConnection();
        $stmt = $conn->prepare("UPDATE comandas SET estado = 'entregado' WHERE id = ? AND estado = 'listo'");
        $stmt->execute([$id]);

        HistorialEntrega::create($id, (int) $user['id'], $observaciones);

        $this->redirect('/entregas');
    }
}
