<?php

namespace App\Models;

use App\Core\Database;

class Article
{
    public static function countPublished(?int $categoryId = null, ?int $tagId = null, ?string $search = null): int
    {
        $sql = 'SELECT COUNT(DISTINCT articles.id) AS total FROM articles'
            . ' LEFT JOIN article_tags ON articles.id = article_tags.article_id'
            . ' WHERE articles.status = "published" AND articles.published_at <= NOW()';
        $params = [];

        if ($categoryId) {
            $sql .= ' AND articles.category_id = ?';
            $params[] = $categoryId;
        }

        if ($tagId) {
            $sql .= ' AND article_tags.tag_id = ?';
            $params[] = $tagId;
        }

        if ($search) {
            $sql .= ' AND (articles.title LIKE ? OR articles.content LIKE ?)';
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
        }

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return (int) ($row['total'] ?? 0);
    }

    public static function published(int $limit, int $offset, ?int $categoryId = null, ?int $tagId = null, ?string $search = null): array
    {
        $sql = 'SELECT articles.*, categories.name AS category_name, categories.slug AS category_slug, users.name AS author_name'
            . ' FROM articles'
            . ' JOIN categories ON categories.id = articles.category_id'
            . ' JOIN users ON users.id = articles.author_id'
            . ' LEFT JOIN article_tags ON articles.id = article_tags.article_id'
            . ' WHERE articles.status = "published" AND articles.published_at <= NOW()';
        $params = [];

        if ($categoryId) {
            $sql .= ' AND articles.category_id = ?';
            $params[] = $categoryId;
        }

        if ($tagId) {
            $sql .= ' AND article_tags.tag_id = ?';
            $params[] = $tagId;
        }

        if ($search) {
            $sql .= ' AND (articles.title LIKE ? OR articles.content LIKE ?)';
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
        }

        $sql .= ' GROUP BY articles.id ORDER BY articles.published_at DESC LIMIT ? OFFSET ?';
        $params[] = $limit;
        $params[] = $offset;

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function featured(): ?array
    {
        $stmt = Database::getConnection()->query('SELECT articles.*, categories.name AS category_name, users.name AS author_name FROM articles JOIN categories ON categories.id = articles.category_id JOIN users ON users.id = articles.author_id WHERE articles.status = "published" AND articles.featured = 1 AND articles.published_at <= NOW() ORDER BY articles.published_at DESC LIMIT 1');
        $article = $stmt->fetch();
        return $article ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT articles.*, categories.name AS category_name, categories.slug AS category_slug, users.name AS author_name FROM articles JOIN categories ON categories.id = articles.category_id JOIN users ON users.id = articles.author_id WHERE articles.slug = ?');
        $stmt->execute([$slug]);
        $article = $stmt->fetch();
        return $article ?: null;
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT articles.*, categories.name AS category_name, categories.slug AS category_slug, users.name AS author_name FROM articles JOIN categories ON categories.id = articles.category_id JOIN users ON users.id = articles.author_id WHERE articles.id = ?');
        $stmt->execute([$id]);
        $article = $stmt->fetch();
        return $article ?: null;
    }

    public static function tags(int $articleId): array
    {
        $stmt = Database::getConnection()->prepare('SELECT tags.* FROM tags JOIN article_tags ON tags.id = article_tags.tag_id WHERE article_tags.article_id = ?');
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }

    public static function related(int $categoryId, int $excludeId): array
    {
        $stmt = Database::getConnection()->prepare('SELECT id, title, slug FROM articles WHERE category_id = ? AND id != ? AND status = "published" ORDER BY published_at DESC LIMIT 4');
        $stmt->execute([$categoryId, $excludeId]);
        return $stmt->fetchAll();
    }

    public static function incrementViews(int $id): void
    {
        $stmt = Database::getConnection()->prepare('UPDATE articles SET views = views + 1 WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function allAdmin(): array
    {
        $stmt = Database::getConnection()->query('SELECT articles.*, categories.name AS category_name FROM articles JOIN categories ON categories.id = articles.category_id ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function create(array $data): int
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO articles (title, slug, excerpt, content, cover_image, category_id, author_id, status, featured, published_at, views, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())');
        $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['excerpt'],
            $data['content'],
            $data['cover_image'],
            $data['category_id'],
            $data['author_id'],
            $data['status'],
            $data['featured'],
            $data['published_at'],
        ]);
        return (int) Database::getConnection()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $stmt = Database::getConnection()->prepare('UPDATE articles SET title = ?, slug = ?, excerpt = ?, content = ?, cover_image = ?, category_id = ?, status = ?, featured = ?, published_at = ?, updated_at = NOW() WHERE id = ?');
        $stmt->execute([
            $data['title'],
            $data['slug'],
            $data['excerpt'],
            $data['content'],
            $data['cover_image'],
            $data['category_id'],
            $data['status'],
            $data['featured'],
            $data['published_at'],
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::getConnection()->prepare('DELETE FROM articles WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function syncTags(int $articleId, array $tagIds): void
    {
        $pdo = Database::getConnection();
        $pdo->prepare('DELETE FROM article_tags WHERE article_id = ?')->execute([$articleId]);
        $stmt = $pdo->prepare('INSERT INTO article_tags (article_id, tag_id) VALUES (?, ?)');
        foreach ($tagIds as $tagId) {
            $stmt->execute([$articleId, $tagId]);
        }
    }
}
