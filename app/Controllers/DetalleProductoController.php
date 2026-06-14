<?php

class DetalleProductoController extends Controller
{
    public function show(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 1;
        $producto = Producto::findById($id);

        if (!$producto) {
            $producto = Producto::findById(1);
        }

        $this->render('shop/detalle-producto', [
            'producto' => $producto,
            'ingredientesExtra' => IngredienteExtra::all(),
            'menuPublic' => $GLOBALS['menuPublic'],
            'redesSociales' => $GLOBALS['redesSociales'],
            'enlacesFooter' => $GLOBALS['enlacesFooter'],
        ]);
    }
}
