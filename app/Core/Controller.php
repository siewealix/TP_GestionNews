<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function adminView(string $view, array $data = []): void
    {
        View::renderAdmin($view, $data);
    }
}
