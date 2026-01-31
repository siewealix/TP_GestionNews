<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Paginator;
use App\Models\Article;

class SearchController extends Controller
{
    public function index(): void
    {
        $query = trim($_GET['q'] ?? '');
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = (int) ($_ENV['PAGINATION_PER_PAGE'] ?? 6);
        $total = $query ? Article::countPublished(null, null, $query) : 0;
        $paginator = new Paginator($page, $perPage, $total);
        $articles = $query ? Article::published($perPage, $paginator->offset(), null, null, $query) : [];

        $this->view('home/search', compact('query', 'articles', 'paginator'));
    }
}
