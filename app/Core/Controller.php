<?php

class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'public'): void
    {
        extract($data);

        $viewFile = __DIR__ . "/../Views/$view.php";

        if ($layout === 'public') {
            require __DIR__ . '/../Views/layouts/header-public.php';
            require $viewFile;
            require __DIR__ . '/../Views/layouts/footer-public.php';
        } elseif ($layout === 'internal') {
            require __DIR__ . '/../Views/layouts/header-internal.php';
            require $viewFile;
            echo "\n</main>\n</body>\n</html>";
        } elseif ($layout === 'none') {
            require $viewFile;
        }
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }

    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            $redirect = str_replace(BASE_URL, '', $_SERVER['REQUEST_URI']);
            $redirect = '/' . ltrim($redirect, '/');
            $this->redirect('/login?redirect=' . urlencode($redirect));
        }
    }

    protected function requireRole(string ...$roles): void
    {
        $this->requireAuth();
        if (!in_array(Auth::role(), $roles)) {
            $redirect = str_replace(BASE_URL, '', $_SERVER['REQUEST_URI']);
            $redirect = '/' . ltrim($redirect, '/');
            $this->redirect('/login?redirect=' . urlencode($redirect));
        }
    }
}
