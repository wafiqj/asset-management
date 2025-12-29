<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Incident\StoreIncidentRequest;
use App\Http\Requests\Incident\UpdateIncidentRequest;
use App\Models\Incident;
use App\Services\IncidentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IncidentApiController extends Controller
{
    public function __construct(
        protected IncidentService $incidentService
    ) {
    }

    /**
     * List incidents
     */
    public function index(Request $request): JsonResponse
    {
        $incidents = Incident::with(['asset', 'reportedBy'])
            ->when($request->input('status'), fn($q, $s) => $q->where('status', $s))
            ->when($request->input('asset_id'), fn($q, $id) => $q->where('asset_id', $id))
            ->orderByDesc('incident_date')
            ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $incidents,
        ]);
    }

    /**
     * Get incident detail
     */
    public function show(Incident $incident): JsonResponse
    {
        $incident->load(['asset', 'reportedBy']);

        return response()->json([
            'success' => true,
            'data' => $incident,
        ]);
    }

    /**
     * Create incident report
     */
    public function store(StoreIncidentRequest $request): JsonResponse
    {
        $incident = $this->incidentService->createIncident($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Incident reported successfully',
            'data' => $incident->load('asset'),
        ], 201);
    }

    /**
     * Update incident (status, resolution, etc)
     */
    public function update(UpdateIncidentRequest $request, Incident $incident): JsonResponse
    {
        $this->incidentService->updateIncident($incident, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Incident updated successfully',
            'data' => $incident->fresh()->load('asset'),
        ]);
    }
}
