<?php

namespace App\Repositories\Contracts;

use App\Models\Incident;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IncidentRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int $id): ?Incident;

    public function create(array $data): Incident;

    public function update(Incident $incident, array $data): Incident;

    public function getByAsset(int $assetId): Collection;

    public function getByStatus(string $status): Collection;

    public function getOpenIncidents(): Collection;

    public function getBySeverity(string $severity): Collection;
}
