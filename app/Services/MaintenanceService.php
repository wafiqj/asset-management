<?php

namespace App\Services;

use App\Models\MaintenanceLog;
use App\Repositories\Contracts\MaintenanceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class MaintenanceService
{
    public function __construct(
        protected MaintenanceRepositoryInterface $repository
    ) {
    }

    public function getPaginatedLogs(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function getLog(int $id): ?MaintenanceLog
    {
        return $this->repository->find($id);
    }

    public function createLog(array $data): MaintenanceLog
    {
        $data['created_by'] = Auth::id();

        return $this->repository->create($data);
    }

    public function getLogsByAsset(int $assetId): Collection
    {
        return $this->repository->getByAsset($assetId);
    }

    public function getLogsByType(string $type): Collection
    {
        return $this->repository->getByType($type);
    }

    public function getLogsByDateRange(string $startDate, string $endDate): Collection
    {
        return $this->repository->getByDateRange($startDate, $endDate);
    }

    public function getTotalMaintenanceCost(int $assetId): float
    {
        return $this->repository->getTotalCostByAsset($assetId);
    }

    public function getMaintenanceStatistics(): array
    {
        $logs = $this->repository->all();

        return [
            'total_logs' => $logs->count(),
            'total_cost' => $logs->sum('cost'),
            'preventive_count' => $logs->where('type', 'Preventive')->count(),
            'corrective_count' => $logs->where('type', 'Corrective')->count(),
            'upgrade_count' => $logs->where('type', 'Upgrade')->count(),
        ];
    }
}
