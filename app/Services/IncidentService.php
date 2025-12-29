<?php

namespace App\Services;

use App\Enums\IncidentStatus;
use App\Models\Incident;
use App\Repositories\Contracts\IncidentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class IncidentService
{
    public function __construct(
        protected IncidentRepositoryInterface $repository
    ) {
    }

    public function getPaginatedIncidents(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function getIncident(int $id): ?Incident
    {
        return $this->repository->find($id);
    }

    public function createIncident(array $data): Incident
    {
        $data['reported_by'] = Auth::id();
        $data['status'] = IncidentStatus::OPEN;

        return $this->repository->create($data);
    }

    public function updateIncident(Incident $incident, array $data): Incident
    {
        return $this->repository->update($incident, $data);
    }

    public function resolveIncident(Incident $incident, array $data): Incident
    {
        return $this->repository->update($incident, [
            'status' => IncidentStatus::RESOLVED,
            'resolved_by' => Auth::id(),
            'resolved_date' => now()->toDateString(),
            'resolution_notes' => $data['resolution_notes'] ?? null,
        ]);
    }

    public function closeIncident(Incident $incident): Incident
    {
        return $this->repository->update($incident, [
            'status' => IncidentStatus::CLOSED,
        ]);
    }

    public function getOpenIncidents(): Collection
    {
        return $this->repository->getOpenIncidents();
    }

    public function getIncidentsByAsset(int $assetId): Collection
    {
        return $this->repository->getByAsset($assetId);
    }

    public function getIncidentStatistics(): array
    {
        $incidents = $this->repository->all();

        return [
            'total' => $incidents->count(),
            'open' => $incidents->where('status', IncidentStatus::OPEN)->count(),
            'in_progress' => $incidents->where('status', IncidentStatus::IN_PROGRESS)->count(),
            'resolved' => $incidents->where('status', IncidentStatus::RESOLVED)->count(),
            'closed' => $incidents->where('status', IncidentStatus::CLOSED)->count(),
            'critical' => $incidents->where('severity', 'Critical')->count(),
        ];
    }
}
