<?php

namespace App\Repositories\Eloquent;

use App\Models\AssetAssignment;
use App\Repositories\Contracts\AssignmentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    public function all(): Collection
    {
        return AssetAssignment::with(['asset', 'user', 'department', 'assignedBy'])->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return AssetAssignment::with(['asset', 'user', 'department', 'assignedBy'])
            ->orderBy('assigned_date', 'desc')
            ->paginate($perPage);
    }

    public function find(int $id): ?AssetAssignment
    {
        return AssetAssignment::with(['asset', 'user', 'department', 'assignedBy'])->find($id);
    }

    public function create(array $data): AssetAssignment
    {
        return AssetAssignment::create($data);
    }

    public function update(AssetAssignment $assignment, array $data): AssetAssignment
    {
        $assignment->update($data);
        return $assignment->fresh();
    }

    public function getByAsset(int $assetId): Collection
    {
        return AssetAssignment::where('asset_id', $assetId)
            ->with(['user', 'department', 'assignedBy'])
            ->orderBy('assigned_date', 'desc')
            ->get();
    }

    public function getByUser(int $userId): Collection
    {
        return AssetAssignment::where('user_id', $userId)
            ->with(['asset', 'department'])
            ->orderBy('assigned_date', 'desc')
            ->get();
    }

    public function getByDepartment(int $departmentId): Collection
    {
        return AssetAssignment::where('department_id', $departmentId)
            ->with(['asset', 'user'])
            ->orderBy('assigned_date', 'desc')
            ->get();
    }

    public function getActiveAssignments(): Collection
    {
        return AssetAssignment::whereNull('return_date')
            ->with(['asset', 'user', 'department'])
            ->get();
    }

    public function getCurrentAssignment(int $assetId): ?AssetAssignment
    {
        return AssetAssignment::where('asset_id', $assetId)
            ->whereNull('return_date')
            ->first();
    }
}
