<?php

namespace App\Models;

use App\Core\Database;

class Tag
{
    public static function all(): array
    {
        $stmt = Database::getConnection()->query('SELECT * FROM tags ORDER BY name');
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM tags WHERE slug = ?');
        $stmt->execute([$slug]);
        $tag = $stmt->fetch();
        return $tag ?: null;
    }

    public static function create(array $data): void
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO tags (name, slug) VALUES (?, ?)');
        $stmt->execute([$data['name'], $data['slug']]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::getConnection()->prepare('DELETE FROM tags WHERE id = ?');
        $stmt->execute([$id]);
    }
}
