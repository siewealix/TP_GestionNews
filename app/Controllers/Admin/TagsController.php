<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Flash;
use App\Core\Helpers;
use App\Core\Validator;
use App\Middleware\AuthMiddleware;
use App\Models\Tag;

class TagsController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $tags = Tag::all();
        $this->adminView('tags/index', compact('tags'));
    }

    public function store(): void
    {
        AuthMiddleware::handle();
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            Helpers::redirect('admin/tags');
        }

        $validator = new Validator();
        $validator->required('name', $_POST['name'] ?? '', 'Nom requis.');

        if (!$validator->passes()) {
            $errors = $validator->errors();
            $tags = Tag::all();
            $this->adminView('tags/index', compact('tags', 'errors'));
            return;
        }

        Tag::create([
            'name' => $_POST['name'],
            'slug' => Helpers::slugify($_POST['name']),
        ]);

        Flash::set('success', 'Tag créé.');
        Helpers::redirect('admin/tags');
    }

    public function delete(string $id): void
    {
        AuthMiddleware::handle();
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            Helpers::redirect('admin/tags');
        }

        Tag::delete((int) $id);
        Flash::set('success', 'Tag supprimé.');
        Helpers::redirect('admin/tags');
    }
}
