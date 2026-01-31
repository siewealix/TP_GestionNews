<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Flash;
use App\Core\Validator;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;
use App\Models\User;

class UsersController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');
        $users = User::all();
        $this->adminView('users/index', compact('users'));
    }

    public function store(): void
    {
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            $this->index();
            return;
        }

        $validator = new Validator();
        $validator->required('name', $_POST['name'] ?? '', 'Nom requis.');
        $validator->email('email', $_POST['email'] ?? '', 'Email invalide.');
        $validator->minLength('password', $_POST['password'] ?? '', 6, 'Mot de passe trop court.');

        if (!$validator->passes()) {
            $errors = $validator->errors();
            $users = User::all();
            $this->adminView('users/index', compact('users', 'errors'));
            return;
        }

        User::create([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => $_POST['role'] ?? 'editor',
        ]);

        Flash::set('success', 'Utilisateur créé.');
        $this->index();
    }

    public function delete(string $id): void
    {
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            $this->index();
            return;
        }

        User::delete((int) $id);
        Flash::set('success', 'Utilisateur supprimé.');
        $this->index();
    }
}
