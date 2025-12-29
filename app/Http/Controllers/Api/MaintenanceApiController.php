<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Maintenance\StoreMaintenanceRequest;
use App\Models\MaintenanceLog;
use App\Services\MaintenanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaintenanceApiController extends Controller
{
    public function __construct(
        protected MaintenanceService $maintenanceService
    ) {
    }

    /**
     * List maintenance logs
     */
    public function index(Request $request): JsonResponse
    {
        $logs = MaintenanceLog::with(['asset'])
            ->when($request->input('asset_id'), fn($q, $id) => $q->where('asset_id', $id))
            ->orderByDesc('maintenance_date')
            ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $logs,
        ]);
    }

    /**
     * Create maintenance log
     */
    public function store(StoreMaintenanceRequest $request): JsonResponse
    {
        $log = $this->maintenanceService->createMaintenanceLog($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Maintenance log created successfully',
            'data' => $log->load('asset'),
        ], 201);
    }
}
