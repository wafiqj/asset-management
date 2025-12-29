<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
use App\Models\Asset;
use App\Services\AssetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetApiController extends Controller
{
    public function __construct(
        protected AssetService $assetService
    ) {
    }

    /**
     * List all assets with optional filters
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'status', 'category_id', 'location_id']);
        $assets = $this->assetService->getPaginatedAssets(
            $request->input('per_page', 15),
            $filters
        );

        return response()->json([
            'success' => true,
            'data' => $assets,
        ]);
    }

    /**
     * Get single asset detail
     */
    public function show(Asset $asset): JsonResponse
    {
        $asset->load(['category', 'location', 'currentAssignment.user', 'currentAssignment.department']);

        return response()->json([
            'success' => true,
            'data' => $asset,
        ]);
    }

    /**
     * Create new asset
     */
    public function store(StoreAssetRequest $request): JsonResponse
    {
        $asset = $this->assetService->createAsset($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Asset created successfully',
            'data' => $asset,
        ], 201);
    }

    /**
     * Update existing asset
     */
    public function update(UpdateAssetRequest $request, Asset $asset): JsonResponse
    {
        $this->assetService->updateAsset($asset, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Asset updated successfully',
            'data' => $asset->fresh(),
        ]);
    }

    /**
     * Delete asset
     */
    public function destroy(Asset $asset): JsonResponse
    {
        $this->assetService->deleteAsset($asset);

        return response()->json([
            'success' => true,
            'message' => 'Asset deleted successfully',
        ]);
    }
}
