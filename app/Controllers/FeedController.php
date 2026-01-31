<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;

class FeedController extends Controller
{
    public function rss(): void
    {
        header('Content-Type: application/rss+xml; charset=utf-8');
        $articles = Article::published(10, 0);
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        echo '<rss version="2.0"><channel>';
        echo '<title>' . htmlspecialchars($_ENV['APP_NAME'] ?? 'Gestion News') . '</title>';
        echo '<link>' . htmlspecialchars($_ENV['APP_URL'] ?? '') . '</link>';
        echo '<description>Derniers articles</description>';
        foreach ($articles as $article) {
            echo '<item>';
            echo '<title>' . htmlspecialchars($article['title']) . '</title>';
            echo '<link>' . htmlspecialchars(($_ENV['APP_URL'] ?? '') . '/article/' . $article['slug']) . '</link>';
            echo '<pubDate>' . date(DATE_RSS, strtotime($article['published_at'])) . '</pubDate>';
            echo '<description>' . htmlspecialchars($article['excerpt']) . '</description>';
            echo '</item>';
        }
        echo '</channel></rss>';
    }
}
