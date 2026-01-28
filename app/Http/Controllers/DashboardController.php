<?php

namespace App\Http\Controllers;

use App\Enums\AssetStatus;
use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\Category;
use App\Models\Department;
use App\Models\MaintenanceLog;
use App\Services\AssetService;
use App\Services\IncidentService;
use App\Services\MaintenanceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected AssetService $assetService,
        protected IncidentService $incidentService,
        protected MaintenanceService $maintenanceService
    ) {
    }

    public function index(): View
    {
        $assetStats = $this->assetService->getAssetStatistics();
        $incidentStats = $this->incidentService->getIncidentStatistics();
        $maintenanceStats = $this->maintenanceService->getMaintenanceStatistics();
        $openIncidents = $this->incidentService->getOpenIncidents()->take(5);

        // New: Assets by Category
        $assetsByCategory = Category::withCount('assets')
            ->orderByDesc('assets_count')
            ->take(5)
            ->get();

        // New: Assets by Department (via assignments)
        $assetsByDepartment = Department::select('departments.id', 'departments.name', 'departments.code')
            ->selectRaw('(SELECT COUNT(DISTINCT asset_id) FROM asset_assignments WHERE asset_assignments.department_id = departments.id AND asset_assignments.return_date IS NULL) as assets_count')
            ->orderByDesc('assets_count')
            ->take(5)
            ->get();

        // New: Recent Assignments
        $recentAssignments = AssetAssignment::with(['asset', 'user', 'department'])
            ->orderByDesc('assigned_date')
            ->take(5)
            ->get();

        // New: Recent Maintenance
        $recentMaintenance = MaintenanceLog::with(['asset'])
            ->orderByDesc('maintenance_date')
            ->take(5)
            ->get();

        // New: Warranty Expiring Soon (next 30 days)
        $warrantyExpiring = Asset::where('warranty_end_date', '>=', Carbon::now())
            ->where('warranty_end_date', '<=', Carbon::now()->addDays(30))
            ->where('status', '!=', 'Retired')
            ->orderBy('warranty_end_date')
            ->take(5)
            ->get();

        // New: Monthly Asset Trend (last 6 months)
        $dateFormat = config('database.default') === 'sqlite' 
            ? "strftime('%Y-%m', created_at)" 
            : "DATE_FORMAT(created_at, '%Y-%m')";
        
        $monthlyTrend = Asset::select(
            DB::raw($dateFormat . " as month"),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('dashboard.index', compact(
            'assetStats',
            'incidentStats',
            'maintenanceStats',
            'openIncidents',
            'assetsByCategory',
            'assetsByDepartment',
            'recentAssignments',
            'recentMaintenance',
            'warrantyExpiring',
            'monthlyTrend'
        ));
    }
}
