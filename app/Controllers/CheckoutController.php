<?php

class CheckoutController extends Controller
{
    public function index(): void
    {
        $this->requireRole('cliente');

        $this->render('dashboard/checkout', [
            'menuPublic' => $GLOBALS['menuPublic'],
        ], 'internal');
    }

    public function confirmar(): void
    {
        $this->requireRole('cliente');

        $input = json_decode(file_get_contents('php://input'), true);

        $user = Auth::user();
        $id = Comanda::create([
            'mesa' => 0,
            'cliente' => $user['nombre'],
            'usuario_id' => $user['id'],
            'total' => $input['total'] ?? 0,
        ], $input['items'] ?? []);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'id' => $id]);
    }
}
