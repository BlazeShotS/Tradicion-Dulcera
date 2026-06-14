<?php

class AuthController extends Controller
{
    public function login(): void
    {
        if (Auth::check()) {
            $this->redirect(self::defaultRoute());
        }

        $error = '';
        $redirect = $_GET['redirect'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = 'Todos los campos son obligatorios.';
            } else {
                $user = User::findByEmail($email);
                if ($user && Auth::attempt($user, $password)) {
                    $redirectTo = $_POST['redirect'] ?: self::defaultRoute();
                    $this->redirect($redirectTo);
                } else {
                    $error = 'Correo o contraseña incorrectos.';
                }
            }
        }

        $this->render('auth/login', [
            'error' => $error,
            'redirect' => $redirect,
            'menuPublic' => $GLOBALS['menuPublic'],
            'redesSociales' => $GLOBALS['redesSociales'],
            'enlacesFooter' => $GLOBALS['enlacesFooter'],
        ]);
    }

    public function register(): void
    {
        if (Auth::check()) {
            $this->redirect(self::defaultRoute());
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($nombre === '' || $email === '' || $password === '') {
                $error = 'Todos los campos son obligatorios.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Correo electrónico inválido.';
            } elseif (strlen($password) < 6) {
                $error = 'La contraseña debe tener al menos 6 caracteres.';
            } elseif (User::findByEmail($email)) {
                $error = 'Este correo ya está registrado.';
            } else {
                $id = User::create([
                    'nombre' => $nombre,
                    'email' => $email,
                    'telefono' => $telefono,
                    'password' => $password,
                    'rol' => 'cliente',
                ]);
                $user = User::findById($id);
                Auth::login($user);
                $this->redirect('/mis-pedidos');
            }
        }

        $this->render('auth/register', [
            'error' => $error,
            'menuPublic' => $GLOBALS['menuPublic'],
            'redesSociales' => $GLOBALS['redesSociales'],
            'enlacesFooter' => $GLOBALS['enlacesFooter'],
        ]);
    }

    private static function defaultRoute(): string
    {
        return match (Auth::role()) {
            'cliente' => '/mis-pedidos',
            'cocina' => '/cocina',
            'admin', 'mozo' => '/panel-mozo',
            default => '/panel-mozo',
        };
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/login');
    }
}
