<?php

namespace App\Controllers;

use App\Core\Database;

class SitemapController
{
    public function index(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        $pdo = Database::getConnection();
        $articles = $pdo->query('SELECT slug, updated_at FROM articles WHERE status = "published" AND published_at <= NOW() ORDER BY updated_at DESC')->fetchAll();

        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        echo '<url><loc>' . htmlspecialchars($_ENV['APP_URL'] ?? '') . '</loc></url>';
        foreach ($articles as $article) {
            echo '<url>';
            echo '<loc>' . htmlspecialchars(($_ENV['APP_URL'] ?? '') . '/article/' . $article['slug']) . '</loc>';
            echo '<lastmod>' . date('Y-m-d', strtotime($article['updated_at'])) . '</lastmod>';
            echo '</url>';
        }
        echo '</urlset>';
    }
}
