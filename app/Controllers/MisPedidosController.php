<?php

class MisPedidosController extends Controller
{
    public function index(): void
    {
        $this->requireRole('cliente');

        $user = Auth::user();
        $comandas = Comanda::findByUser($user['id']);

        $this->render('dashboard/mis-pedidos', [
            'comandas' => $comandas,
            'menuPublic' => $GLOBALS['menuPublic'],
            'redesSociales' => $GLOBALS['redesSociales'],
            'enlacesFooter' => $GLOBALS['enlacesFooter'],
        ], 'public');
    }
}
