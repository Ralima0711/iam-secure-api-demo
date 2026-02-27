<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo responsável por representar
 * eventos de auditoria da aplicação.
 */
class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'event',
        'ip_address',
        'user_agent',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}