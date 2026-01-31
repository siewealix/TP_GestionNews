<?php

namespace App\Models;

use App\Core\Database;

class Setting
{
    public static function all(): array
    {
        $stmt = Database::getConnection()->query('SELECT * FROM settings');
        $settings = [];
        foreach ($stmt->fetchAll() as $row) {
            $settings[$row['key']] = $row['value'];
        }
        return $settings;
    }

    public static function update(array $data): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('REPLACE INTO settings (`key`, `value`) VALUES (?, ?)');
        foreach ($data as $key => $value) {
            $stmt->execute([$key, $value]);
        }
    }
}
