<?php

namespace App\Infrastructure\Logging;

use App\Domain\Contracts\AuditServiceInterface;
use App\Models\AuditLog;

/**
 * Implementação concreta da auditoria
 * persistindo em banco de dados.
 */
class AuditDatabaseService implements AuditServiceInterface
{
    public function log(
        string $event,
        ?int $userId,
        ?string $ip,
        ?string $userAgent,
        array $metadata = []
    ): void {
        AuditLog::create([
            'user_id' => $userId,
            'event' => $event,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'metadata' => $metadata,
        ]);
    }
}