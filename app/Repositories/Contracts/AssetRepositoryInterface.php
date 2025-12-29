<?php

namespace App\Repositories\Contracts;

use App\Models\Asset;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AssetRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function find(int $id): ?Asset;

    public function findByAssetId(string $assetId): ?Asset;

    public function findBySerialNumber(string $serialNumber): ?Asset;

    public function create(array $data): Asset;

    public function update(Asset $asset, array $data): Asset;

    public function delete(Asset $asset): bool;

    public function getByStatus(string $status): Collection;

    public function getByCategory(int $categoryId): Collection;

    public function getByLocation(int $locationId): Collection;

    public function search(string $query): Collection;
}
