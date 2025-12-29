<?php

namespace App\Repositories\Eloquent;

use App\Models\MaintenanceLog;
use App\Repositories\Contracts\MaintenanceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MaintenanceRepository implements MaintenanceRepositoryInterface
{
    public function all(): Collection
    {
        return MaintenanceLog::with(['asset', 'createdBy'])->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return MaintenanceLog::with(['asset', 'createdBy'])
            ->orderBy('maintenance_date', 'desc')
            ->paginate($perPage);
    }

    public function find(int $id): ?MaintenanceLog
    {
        return MaintenanceLog::with(['asset', 'createdBy'])->find($id);
    }

    public function create(array $data): MaintenanceLog
    {
        return MaintenanceLog::create($data);
    }

    public function getByAsset(int $assetId): Collection
    {
        return MaintenanceLog::where('asset_id', $assetId)
            ->with('createdBy')
            ->orderBy('maintenance_date', 'desc')
            ->get();
    }

    public function getByType(string $type): Collection
    {
        return MaintenanceLog::where('type', $type)
            ->with(['asset', 'createdBy'])
            ->orderBy('maintenance_date', 'desc')
            ->get();
    }

    public function getByDateRange(string $startDate, string $endDate): Collection
    {
        return MaintenanceLog::whereBetween('maintenance_date', [$startDate, $endDate])
            ->with(['asset', 'createdBy'])
            ->orderBy('maintenance_date', 'desc')
            ->get();
    }

    public function getTotalCostByAsset(int $assetId): float
    {
        return (float) MaintenanceLog::where('asset_id', $assetId)->sum('cost');
    }
}
