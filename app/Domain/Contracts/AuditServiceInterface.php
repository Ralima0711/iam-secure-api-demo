<?php

namespace App\Domain\Contracts;

/**
 * Contrato responsável por registrar
 * eventos de auditoria.
 */
interface AuditServiceInterface
{
    public function log(
        string $event,
        ?int $userId,
        ?string $ip,
        ?string $userAgent,
        array $metadata = []
    ): void;
}