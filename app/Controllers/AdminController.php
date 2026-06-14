<?php

class AdminController extends Controller
{
    public function index(): void
    {
        $this->requireRole('admin');

        $comandas = Comanda::all();

        $this->render('dashboard/admin', [
            'comandas' => $comandas,
            'menuInternal' => $GLOBALS['menuInternal'],
        ], 'internal');
    }
}
