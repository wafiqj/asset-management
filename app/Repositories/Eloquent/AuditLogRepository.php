<?php

namespace App\Repositories\Eloquent;

use App\Models\AuditLog;
use App\Repositories\Contracts\AuditLogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AuditLogRepository implements AuditLogRepositoryInterface
{
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = AuditLog::with('user');

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['auditable_type'])) {
            $query->where('auditable_type', $filters['auditable_type']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getByUser(int $userId): Collection
    {
        return AuditLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByModel(string $modelType, int $modelId): Collection
    {
        return AuditLog::where('auditable_type', $modelType)
            ->where('auditable_id', $modelId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByAction(string $action): Collection
    {
        return AuditLog::where('action', $action)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByDateRange(string $startDate, string $endDate): Collection
    {
        return AuditLog::whereBetween('created_at', [$startDate, $endDate])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(array $data): AuditLog
    {
        return AuditLog::create($data);
    }
}
