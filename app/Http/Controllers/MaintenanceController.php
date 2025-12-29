<?php

namespace App\Http\Controllers;

use App\Enums\MaintenanceType;
use App\Http\Requests\Maintenance\StoreMaintenanceRequest;
use App\Models\Asset;
use App\Services\MaintenanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function __construct(
        protected MaintenanceService $maintenanceService
    ) {
    }

    public function index(): View
    {
        $logs = $this->maintenanceService->getPaginatedLogs();

        return view('maintenance.index', compact('logs'));
    }

    public function create(?Asset $asset = null): View
    {
        $assets = Asset::all();
        $types = MaintenanceType::cases();

        return view('maintenance.create', compact('assets', 'types', 'asset'));
    }

    public function store(StoreMaintenanceRequest $request): RedirectResponse
    {
        $log = $this->maintenanceService->createLog($request->validated());

        return redirect()->route('assets.show', $log->asset_id)
            ->with('success', 'Maintenance log berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $log = $this->maintenanceService->getLog($id);

        return view('maintenance.show', compact('log'));
    }
}
