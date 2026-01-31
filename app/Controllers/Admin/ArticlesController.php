<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Flash;
use App\Core\Helpers;
use App\Core\Validator;
use App\Middleware\AuthMiddleware;
use App\Models\Article;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Tag;

class ArticlesController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $articles = Article::allAdmin();
        $this->adminView('articles/index', compact('articles'));
    }

    public function create(): void
    {
        AuthMiddleware::handle();
        $categories = Category::all();
        $tags = Tag::all();
        $this->adminView('articles/create', compact('categories', 'tags'));
    }

    public function store(): void
    {
        AuthMiddleware::handle();
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            Helpers::redirect('admin/articles/create');
        }

        $validator = new Validator();
        $validator->required('title', $_POST['title'] ?? '', 'Titre requis.');
        $validator->required('content', $_POST['content'] ?? '', 'Contenu requis.');
        $validator->required('category_id', $_POST['category_id'] ?? '', 'Catégorie requise.');

        if (!$validator->passes()) {
            $errors = $validator->errors();
            $categories = Category::all();
            $tags = Tag::all();
            $this->adminView('articles/create', compact('categories', 'tags', 'errors'));
            return;
        }

        $coverImage = $this->handleUpload('cover_image');
        $slug = Helpers::slugify($_POST['title']);

        $articleId = Article::create([
            'title' => $_POST['title'],
            'slug' => $slug,
            'excerpt' => $_POST['excerpt'] ?? '',
            'content' => $_POST['content'],
            'cover_image' => $coverImage,
            'category_id' => (int) $_POST['category_id'],
            'author_id' => (int) (Auth::user()['id'] ?? 1),
            'status' => $_POST['status'] ?? 'draft',
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'published_at' => $_POST['published_at'] ?: null,
        ]);

        $tagIds = $_POST['tags'] ?? [];
        Article::syncTags($articleId, $tagIds);
        AuditLog::create((int) (Auth::user()['id'] ?? 1), 'create', 'article', $articleId, ['title' => $_POST['title']]);

        Flash::set('success', 'Article créé.');
        Helpers::redirect('admin/articles');
    }

    public function edit(string $id): void
    {
        AuthMiddleware::handle();
        $article = Article::findById((int) $id);
        if (!$article) {
            $articles = Article::allAdmin();
            $this->adminView('articles/index', compact('articles'));
            return;
        }
        $categories = Category::all();
        $tags = Tag::all();
        $selectedTags = array_column(Article::tags((int) $article['id']), 'id');
        $this->adminView('articles/edit', compact('article', 'categories', 'tags', 'selectedTags'));
    }

    public function update(string $id): void
    {
        AuthMiddleware::handle();
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            Helpers::redirect('admin/articles');
        }

        $article = Article::findById((int) $id);
        if (!$article) {
            Helpers::redirect('admin/articles');
        }

        $coverImage = $article['cover_image'];
        if (!empty($_FILES['cover_image']['name'])) {
            $coverImage = $this->handleUpload('cover_image');
        }

        $slug = Helpers::slugify($_POST['title']);

        Article::update((int) $article['id'], [
            'title' => $_POST['title'],
            'slug' => $slug,
            'excerpt' => $_POST['excerpt'] ?? '',
            'content' => $_POST['content'],
            'cover_image' => $coverImage,
            'category_id' => (int) $_POST['category_id'],
            'status' => $_POST['status'] ?? 'draft',
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'published_at' => $_POST['published_at'] ?: null,
        ]);

        $tagIds = $_POST['tags'] ?? [];
        Article::syncTags((int) $article['id'], $tagIds);
        AuditLog::create((int) (Auth::user()['id'] ?? 1), 'update', 'article', (int) $article['id'], ['title' => $_POST['title']]);

        Flash::set('success', 'Article mis à jour.');
        Helpers::redirect('admin/articles');
    }

    public function delete(string $id): void
    {
        AuthMiddleware::handle();
        if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
            Flash::set('error', 'Jeton CSRF invalide.');
            Helpers::redirect('admin/articles');
        }

        $article = Article::findById((int) $id);
        if ($article) {
            Article::delete((int) $article['id']);
            AuditLog::create((int) (Auth::user()['id'] ?? 1), 'delete', 'article', (int) $article['id']);
        }

        Flash::set('success', 'Article supprimé.');
        Helpers::redirect('admin/articles');
    }

    private function handleUpload(string $field): ?string
    {
        if (empty($_FILES[$field]['name'])) {
            return null;
        }

        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $file = $_FILES[$field];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        if (!in_array(mime_content_type($file['tmp_name']), $allowed, true)) {
            return null;
        }

        $maxSize = (int) ($_ENV['UPLOAD_MAX_SIZE'] ?? 2097152);
        if ($file['size'] > $maxSize) {
            return null;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = bin2hex(random_bytes(12)) . '.' . $extension;
        $destination = __DIR__ . '/../../../public/uploads/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return null;
        }

        return 'uploads/' . $filename;
    }
}
