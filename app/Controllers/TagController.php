<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Paginator;
use App\Models\Article;
use App\Models\Tag;

class TagController extends Controller
{
    public function show(string $slug): void
    {
        $tag = Tag::findBySlug($slug);
        if (!$tag) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_ENV['PAGINATION_PER_PAGE'] ?? 6);
        $total = Article::countPublished(null, (int) $tag['id']);
        $paginator = new Paginator($page, $perPage, $total);
        $articles = Article::published($perPage, $paginator->offset(), null, (int) $tag['id']);

        $this->view('categories/tag', compact('tag', 'articles', 'paginator'));
    }
}
