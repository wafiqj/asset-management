<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Services\AssignmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssignmentApiController extends Controller
{
    public function __construct(
        protected AssignmentService $assignmentService
    ) {
    }

    /**
     * List all assignments
     */
    public function index(Request $request): JsonResponse
    {
        $assignments = AssetAssignment::with(['asset', 'user', 'department'])
            ->when($request->input('active_only'), fn($q) => $q->whereNull('return_date'))
            ->orderByDesc('assigned_date')
            ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $assignments,
        ]);
    }

    /**
     * Assign asset to user/department
     */
    public function assign(Request $request, Asset $asset): JsonResponse
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            $assignment = $this->assignmentService->assignAsset(
                $asset,
                $request->all(),
                auth()->id() ?? 1 // Default to admin if no auth context
            );

            return response()->json([
                'success' => true,
                'message' => 'Asset assigned successfully',
                'data' => $assignment->load(['asset', 'user', 'department']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Return assigned asset
     */
    public function return(Request $request, Asset $asset): JsonResponse
    {
        $request->validate([
            'return_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            $assignment = $this->assignmentService->returnAsset(
                $asset,
                $request->all()
            );

            return response()->json([
                'success' => true,
                'message' => 'Asset returned successfully',
                'data' => $assignment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
