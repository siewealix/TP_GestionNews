<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Middleware\AuthMiddleware;

class DashboardController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();
        $pdo = Database::getConnection();
        $stats = [
            'published' => (int) $pdo->query("SELECT COUNT(*) FROM articles WHERE status = 'published'")->fetchColumn(),
            'drafts' => (int) $pdo->query("SELECT COUNT(*) FROM articles WHERE status = 'draft'")->fetchColumn(),
            'scheduled' => (int) $pdo->query("SELECT COUNT(*) FROM articles WHERE status = 'scheduled'")->fetchColumn(),
        ];
        $topCategories = $pdo->query('SELECT categories.name, COUNT(articles.id) AS total FROM categories LEFT JOIN articles ON articles.category_id = categories.id GROUP BY categories.id ORDER BY total DESC LIMIT 5')->fetchAll();

        $this->adminView('dashboard', compact('stats', 'topCategories'));
    }
}
