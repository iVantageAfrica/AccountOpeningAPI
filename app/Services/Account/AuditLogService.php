<?php

namespace App\Services\Account;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogService
{
    public static function record(int|string|null $adminId, string $action, ?string $description = null, ?Request $request = null, ?array $metadata = null): ?AuditLog
    {
        return AuditLog::create([
            'admin_id' => $adminId,
            'action' => $action,
            'description' => $description,
            'ip_address' => $request ? $request->ip() : null,
            'user_agent' => $request ? substr((string) $request->userAgent(), 0, 500) : null,
            'metadata' => $metadata,
        ]);
    }

    public static function list(?int $adminId, ?string $action, ?string $from, ?string $to): \Illuminate\Database\Eloquent\Builder
    {
        $query = AuditLog::with('admin:id,firstname,lastname,email')
            ->orderByDesc('id');

        if ($adminId) {
            $query->where('admin_id', $adminId);
        }

        if ($action) {
            $query->where('action', $action);
        }

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        return $query;
    }
}
