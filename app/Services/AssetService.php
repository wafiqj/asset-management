<?php

namespace App\Services;

use App\Enums\AssetStatus;
use App\Models\Asset;
use App\Repositories\Contracts\AssetRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AssetService
{
    public function __construct(
        protected AssetRepositoryInterface $repository,
        protected AssetIdGeneratorService $idGenerator
    ) {
    }

    public function getAllAssets(): Collection
    {
        return $this->repository->all();
    }

    public function getPaginatedAssets(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $filters);
    }

    public function getAsset(int $id): ?Asset
    {
        return $this->repository->find($id);
    }

    public function createAsset(array $data): Asset
    {
        $data['asset_id'] = $this->idGenerator->generate();
        $data['status'] = AssetStatus::AVAILABLE;

        return $this->repository->create($data);
    }

    public function updateAsset(Asset $asset, array $data): Asset
    {
        // Prevent asset_id modification
        unset($data['asset_id']);

        return $this->repository->update($asset, $data);
    }

    public function deleteAsset(Asset $asset): bool
    {
        return $this->repository->delete($asset);
    }

    public function setAssetStatus(Asset $asset, AssetStatus $status): Asset
    {
        return $this->repository->update($asset, ['status' => $status]);
    }

    public function getAssetsByStatus(string $status): Collection
    {
        return $this->repository->getByStatus($status);
    }

    public function searchAssets(string $query): Collection
    {
        return $this->repository->search($query);
    }

    public function getAssetStatistics(): array
    {
        $assets = $this->repository->all();

        return [
            'total' => $assets->count(),
            'available' => $assets->where('status', AssetStatus::AVAILABLE)->count(),
            'in_use' => $assets->where('status', AssetStatus::IN_USE)->count(),
            'maintenance' => $assets->where('status', AssetStatus::MAINTENANCE)->count(),
            'retired' => $assets->where('status', AssetStatus::RETIRED)->count(),
            'total_value' => $assets->sum('asset_value'),
        ];
    }
}
