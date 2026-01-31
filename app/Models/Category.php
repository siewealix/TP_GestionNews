<?php

namespace App\Models;

use App\Core\Database;

class Category
{
    public static function all(): array
    {
        $stmt = Database::getConnection()->query('SELECT * FROM categories ORDER BY name');
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM categories WHERE slug = ?');
        $stmt->execute([$slug]);
        $category = $stmt->fetch();
        return $category ?: null;
    }

    public static function create(array $data): void
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO categories (name, slug, created_at) VALUES (?, ?, NOW())');
        $stmt->execute([$data['name'], $data['slug']]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::getConnection()->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->execute([$id]);
    }
}
