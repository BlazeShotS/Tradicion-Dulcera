<?php

class CartaController extends Controller
{
    public function index(): void
    {
        $this->render('shop/carta', [
            'productos' => Producto::all(),
            'menuPublic' => $GLOBALS['menuPublic'],
            'redesSociales' => $GLOBALS['redesSociales'],
            'enlacesFooter' => $GLOBALS['enlacesFooter'],
        ]);
    }
}
