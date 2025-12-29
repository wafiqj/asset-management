<?php

namespace App\Repositories\Contracts;

use App\Models\MaintenanceLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface MaintenanceRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int $id): ?MaintenanceLog;

    public function create(array $data): MaintenanceLog;

    public function getByAsset(int $assetId): Collection;

    public function getByType(string $type): Collection;

    public function getByDateRange(string $startDate, string $endDate): Collection;

    public function getTotalCostByAsset(int $assetId): float;
}
