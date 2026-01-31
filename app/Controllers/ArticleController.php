<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Flash;
use App\Models\Article;

class ArticleController extends Controller
{
    public function show(string $slug): void
    {
        $article = Article::findBySlug($slug);
        if (!$article) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $viewKey = 'viewed_article_' . $article['id'];
        if (empty($_SESSION[$viewKey])) {
            Article::incrementViews((int) $article['id']);
            $_SESSION[$viewKey] = true;
        }

        $tags = Article::tags((int) $article['id']);
        $related = Article::related((int) $article['category_id'], (int) $article['id']);

        $this->view('articles/show', compact('article', 'tags', 'related'));
    }
}
