<?php

namespace App\Repositories\Contracts;

use App\Models\AssetAssignment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AssignmentRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int $id): ?AssetAssignment;

    public function create(array $data): AssetAssignment;

    public function update(AssetAssignment $assignment, array $data): AssetAssignment;

    public function getByAsset(int $assetId): Collection;

    public function getByUser(int $userId): Collection;

    public function getByDepartment(int $departmentId): Collection;

    public function getActiveAssignments(): Collection;

    public function getCurrentAssignment(int $assetId): ?AssetAssignment;
}
