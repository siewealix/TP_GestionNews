<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Flash;
use App\Core\Helpers;

class AuthController extends Controller
{
    private int $maxAttempts = 5;

    public function loginForm(): void
    {
        $this->view('auth/login');
    }

    public function login(): void
    {
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            $this->loginForm();
            return;
        }

        $attempts = $_SESSION['login_attempts'] ?? 0;
        if ($attempts >= $this->maxAttempts) {
            Flash::set('error', 'Trop de tentatives. Réessayez plus tard.');
            $this->loginForm();
            return;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Auth::attempt($email, $password)) {
            $_SESSION['login_attempts'] = 0;
            Helpers::redirect('admin');
            return;
        }

        $_SESSION['login_attempts'] = $attempts + 1;
        Flash::set('error', 'Identifiants invalides.');
        $this->loginForm();
    }

    public function logout(): void
    {
        Auth::logout();
        Helpers::redirect('');
    }
}
