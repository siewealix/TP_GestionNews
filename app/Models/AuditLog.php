<?php

namespace App\Models;

use App\Core\Database;

class AuditLog
{
    public static function create(int $userId, string $action, string $entity, int $entityId, array $data = []): void
    {
        $stmt = Database::getConnection()->prepare('INSERT INTO audit_logs (user_id, action, entity, entity_id, data_json, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$userId, $action, $entity, $entityId, json_encode($data)]);
    }
}
