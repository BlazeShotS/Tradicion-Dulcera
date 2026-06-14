<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('home/index', [
            'pilares' => Pilar::all(),
            'menuPublic' => $GLOBALS['menuPublic'],
            'redesSociales' => $GLOBALS['redesSociales'],
            'enlacesFooter' => $GLOBALS['enlacesFooter'],
        ]);
    }
}
