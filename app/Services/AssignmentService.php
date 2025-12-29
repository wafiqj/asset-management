<?php

namespace App\Services;

use App\Enums\AssetStatus;
use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Repositories\Contracts\AssetRepositoryInterface;
use App\Repositories\Contracts\AssignmentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AssignmentService
{
    public function __construct(
        protected AssignmentRepositoryInterface $assignmentRepository,
        protected AssetRepositoryInterface $assetRepository
    ) {
    }

    public function getPaginatedAssignments(int $perPage = 15): LengthAwarePaginator
    {
        return $this->assignmentRepository->paginate($perPage);
    }

    public function getAssignment(int $id): ?AssetAssignment
    {
        return $this->assignmentRepository->find($id);
    }

    public function getAssetHistory(int $assetId): Collection
    {
        return $this->assignmentRepository->getByAsset($assetId);
    }

    public function assignAsset(Asset $asset, array $data): AssetAssignment
    {
        if (!$asset->isAvailable()) {
            throw new InvalidArgumentException('Asset is not available for assignment.');
        }

        return DB::transaction(function () use ($asset, $data) {
            // Create assignment record
            $assignment = $this->assignmentRepository->create([
                'asset_id' => $asset->id,
                'user_id' => $data['user_id'] ?? null,
                'department_id' => $data['department_id'],
                'assigned_by' => Auth::id(),
                'assigned_date' => $data['assigned_date'] ?? now()->toDateString(),
                'notes' => $data['notes'] ?? null,
            ]);

            // Update asset status
            $this->assetRepository->update($asset, ['status' => AssetStatus::IN_USE]);

            return $assignment;
        });
    }

    public function returnAsset(Asset $asset, array $data = []): AssetAssignment
    {
        $currentAssignment = $this->assignmentRepository->getCurrentAssignment($asset->id);

        if (!$currentAssignment) {
            throw new InvalidArgumentException('Asset is not currently assigned.');
        }

        return DB::transaction(function () use ($asset, $currentAssignment, $data) {
            // Update assignment with return date
            $assignment = $this->assignmentRepository->update($currentAssignment, [
                'return_date' => $data['return_date'] ?? now()->toDateString(),
                'notes' => $data['notes'] ?? $currentAssignment->notes,
            ]);

            // Update asset status
            $this->assetRepository->update($asset, ['status' => AssetStatus::AVAILABLE]);

            return $assignment;
        });
    }

    public function getActiveAssignments(): Collection
    {
        return $this->assignmentRepository->getActiveAssignments();
    }

    public function getUserAssignments(int $userId): Collection
    {
        return $this->assignmentRepository->getByUser($userId);
    }

    public function getDepartmentAssignments(int $departmentId): Collection
    {
        return $this->assignmentRepository->getByDepartment($departmentId);
    }
}
