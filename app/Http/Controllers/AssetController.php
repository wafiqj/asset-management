<?php

namespace App\Http\Controllers;

use App\Enums\AssetStatus;
use App\Http\Requests\Asset\StoreAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use App\Services\AssetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetController extends Controller
{
    public function __construct(
        protected AssetService $assetService
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'category_id', 'location_id']);
        $assets = $this->assetService->getPaginatedAssets(15, $filters);
        $categories = Category::all();
        $locations = Location::all();
        $statuses = AssetStatus::cases();

        return view('assets.index', compact('assets', 'categories', 'locations', 'statuses', 'filters'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('assets.create', compact('categories', 'locations'));
    }

    public function store(StoreAssetRequest $request): RedirectResponse
    {
        $asset = $this->assetService->createAsset($request->validated());

        return redirect()->route('assets.show', $asset)
            ->with('success', 'Asset berhasil ditambahkan dengan ID: ' . $asset->asset_id);
    }

    public function show(Asset $asset): View
    {
        $asset->load(['category', 'location', 'assignments.user', 'assignments.department', 'maintenanceLogs', 'incidents']);

        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset): View
    {
        $categories = Category::all();
        $locations = Location::all();
        $statuses = AssetStatus::cases();

        return view('assets.edit', compact('asset', 'categories', 'locations', 'statuses'));
    }

    public function update(UpdateAssetRequest $request, Asset $asset): RedirectResponse
    {
        $this->assetService->updateAsset($asset, $request->validated());

        return redirect()->route('assets.show', $asset)
            ->with('success', 'Asset berhasil diperbarui.');
    }

    public function destroy(Asset $asset): RedirectResponse
    {
        $this->assetService->deleteAsset($asset);

        return redirect()->route('assets.index')
            ->with('success', 'Asset berhasil dihapus.');
    }
}
