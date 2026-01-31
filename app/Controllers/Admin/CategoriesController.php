<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Flash;
use App\Core\Helpers;
use App\Core\Validator;
use App\Middleware\AuthMiddleware;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $categories = Category::all();
        $this->adminView('categories/index', compact('categories'));
    }

    public function store(): void
    {
        AuthMiddleware::handle();
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            Helpers::redirect('admin/categories');
        }

        $validator = new Validator();
        $validator->required('name', $_POST['name'] ?? '', 'Nom requis.');

        if (!$validator->passes()) {
            $errors = $validator->errors();
            $categories = Category::all();
            $this->adminView('categories/index', compact('categories', 'errors'));
            return;
        }

        Category::create([
            'name' => $_POST['name'],
            'slug' => Helpers::slugify($_POST['name']),
        ]);

        Flash::set('success', 'Catégorie créée.');
        Helpers::redirect('admin/categories');
    }

    public function delete(string $id): void
    {
        AuthMiddleware::handle();
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            Helpers::redirect('admin/categories');
        }

        Category::delete((int) $id);
        Flash::set('success', 'Catégorie supprimée.');
        Helpers::redirect('admin/categories');
    }
}
