<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Paginator;
use App\Models\Article;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(string $slug): void
    {
        $category = Category::findBySlug($slug);
        if (!$category) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_ENV['PAGINATION_PER_PAGE'] ?? 6);
        $total = Article::countPublished((int) $category['id']);
        $paginator = new Paginator($page, $perPage, $total);
        $articles = Article::published($perPage, $paginator->offset(), (int) $category['id']);

        $this->view('categories/show', compact('category', 'articles', 'paginator'));
    }
}
