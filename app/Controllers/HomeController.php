<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Flash;
use App\Core\Paginator;
use App\Core\Validator;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(): void
    {
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_ENV['PAGINATION_PER_PAGE'] ?? 6);
        $total = Article::countPublished();
        $paginator = new Paginator($page, $perPage, $total);
        $articles = Article::published($perPage, $paginator->offset());
        $featured = Article::featured();
        $categories = Category::all();

        $this->view('home/index', compact('articles', 'featured', 'paginator', 'categories'));
    }

    public function about(): void
    {
        $this->view('home/about');
    }

    public function contact(): void
    {
        $this->view('home/contact');
    }

    public function contactSubmit(): void
    {
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            $this->contact();
            return;
        }

        $validator = new Validator();
        $validator->required('name', $_POST['name'] ?? '', 'Nom requis.');
        $validator->email('email', $_POST['email'] ?? '', 'Email invalide.');
        $validator->minLength('message', $_POST['message'] ?? '', 10, 'Message trop court.');

        if (!$validator->passes()) {
            $errors = $validator->errors();
            $this->view('home/contact', compact('errors'));
            return;
        }

        $stmt = Database::getConnection()->prepare('INSERT INTO contact_messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['message'],
        ]);

        Flash::set('success', 'Message envoyé. Merci !');
        $this->view('home/contact');
    }
}
