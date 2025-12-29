<?php

namespace App\Repositories\Eloquent;

use App\Models\Asset;
use App\Repositories\Contracts\AssetRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AssetRepository implements AssetRepositoryInterface
{
    public function all(): Collection
    {
        return Asset::with(['category', 'location'])->get();
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Asset::with(['category', 'location', 'currentAssignment.user']);

        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['status'])) {
            $query->status($filters['status']);
        }

        if (!empty($filters['category_id'])) {
            $query->category($filters['category_id']);
        }

        if (!empty($filters['location_id'])) {
            $query->location($filters['location_id']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find(int $id): ?Asset
    {
        return Asset::with(['category', 'location', 'assignments.user', 'maintenanceLogs', 'incidents'])
            ->find($id);
    }

    public function findByAssetId(string $assetId): ?Asset
    {
        return Asset::where('asset_id', $assetId)->first();
    }

    public function findBySerialNumber(string $serialNumber): ?Asset
    {
        return Asset::where('serial_number', $serialNumber)->first();
    }

    public function create(array $data): Asset
    {
        return Asset::create($data);
    }

    public function update(Asset $asset, array $data): Asset
    {
        $asset->update($data);
        return $asset->fresh();
    }

    public function delete(Asset $asset): bool
    {
        return $asset->delete();
    }

    public function getByStatus(string $status): Collection
    {
        return Asset::where('status', $status)->get();
    }

    public function getByCategory(int $categoryId): Collection
    {
        return Asset::where('category_id', $categoryId)->get();
    }

    public function getByLocation(int $locationId): Collection
    {
        return Asset::where('location_id', $locationId)->get();
    }

    public function search(string $query): Collection
    {
        return Asset::search($query)->get();
    }
}
