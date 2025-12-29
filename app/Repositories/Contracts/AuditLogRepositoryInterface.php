<?php

namespace App\Repositories\Contracts;

use App\Models\AuditLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AuditLogRepositoryInterface
{
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function getByUser(int $userId): Collection;

    public function getByModel(string $modelType, int $modelId): Collection;

    public function getByAction(string $action): Collection;

    public function getByDateRange(string $startDate, string $endDate): Collection;

    public function create(array $data): AuditLog;
}
