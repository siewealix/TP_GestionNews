<?php

namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        $layoutPath = __DIR__ . '/../Views/layouts/main.php';

        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo 'View not found.';
            return;
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require $layoutPath;
    }

    public static function renderAdmin(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../Views/admin/' . $view . '.php';
        $layoutPath = __DIR__ . '/../Views/layouts/admin.php';

        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo 'Admin view not found.';
            return;
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require $layoutPath;
    }
}
