<?php

namespace App\Repositories\Eloquent;

use App\Enums\IncidentStatus;
use App\Models\Incident;
use App\Repositories\Contracts\IncidentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class IncidentRepository implements IncidentRepositoryInterface
{
    public function all(): Collection
    {
        return Incident::with(['asset', 'reportedBy', 'resolvedBy'])->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Incident::with(['asset', 'reportedBy', 'resolvedBy'])
            ->orderBy('incident_date', 'desc')
            ->paginate($perPage);
    }

    public function find(int $id): ?Incident
    {
        return Incident::with(['asset', 'reportedBy', 'resolvedBy'])->find($id);
    }

    public function create(array $data): Incident
    {
        return Incident::create($data);
    }

    public function update(Incident $incident, array $data): Incident
    {
        $incident->update($data);
        return $incident->fresh();
    }

    public function getByAsset(int $assetId): Collection
    {
        return Incident::where('asset_id', $assetId)
            ->with(['reportedBy', 'resolvedBy'])
            ->orderBy('incident_date', 'desc')
            ->get();
    }

    public function getByStatus(string $status): Collection
    {
        return Incident::where('status', $status)
            ->with(['asset', 'reportedBy'])
            ->orderBy('incident_date', 'desc')
            ->get();
    }

    public function getOpenIncidents(): Collection
    {
        return Incident::whereIn('status', [IncidentStatus::OPEN, IncidentStatus::IN_PROGRESS])
            ->with(['asset', 'reportedBy'])
            ->orderBy('severity', 'desc')
            ->orderBy('incident_date', 'desc')
            ->get();
    }

    public function getBySeverity(string $severity): Collection
    {
        return Incident::where('severity', $severity)
            ->with(['asset', 'reportedBy'])
            ->orderBy('incident_date', 'desc')
            ->get();
    }
}
