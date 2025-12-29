<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            static::logAudit('create', $model, null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $oldValues = $model->getOriginal();
            $newValues = $model->getChanges();

            // Remove timestamps from audit
            unset($oldValues['updated_at'], $newValues['updated_at']);

            if (!empty($newValues)) {
                static::logAudit('update', $model, $oldValues, $newValues);
            }
        });

        static::deleted(function ($model) {
            static::logAudit('delete', $model, $model->getOriginal(), null);
        });
    }

    protected static function logAudit(string $action, $model, ?array $oldValues, ?array $newValues): void
    {
        if (!Auth::check()) {
            return;
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'created_at' => now(),
        ]);
    }
}
