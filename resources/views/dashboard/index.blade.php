@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-gradient-primary">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Assets</h6>
                        <h2 class="mb-0">{{ number_format($assetStats['total']) }}</h2>
                    </div>
                    <i class="bi bi-pc-display fs-1 opacity-50"></i>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white text-warning">Rp
                        {{ number_format($assetStats['total_value'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-gradient-success">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white-50 mb-1">Available</h6>
                        <h2 class="mb-0">{{ number_format($assetStats['available']) }}</h2>
                    </div>
                    <i class="bi bi-check-circle fs-1 opacity-50"></i>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white text-success">Ready to assign</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-gradient-warning">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white-50 mb-1">In Use</h6>
                        <h2 class="mb-0">{{ number_format($assetStats['in_use']) }}</h2>
                    </div>
                    <i class="bi bi-person-check fs-1 opacity-50"></i>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white text-danger">Assigned</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-gradient-danger">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="text-white-50 mb-1">Open Incidents</h6>
                        <h2 class="mb-0">{{ number_format($incidentStats['open'] + $incidentStats['in_progress']) }}</h2>
                    </div>
                    <i class="bi bi-exclamation-triangle fs-1 opacity-50"></i>
                </div>
                <div class="mt-3">
                    <span class="badge bg-white text-black">{{ $incidentStats['critical'] }} Critical</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Incidents & Asset Status -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-exclamation-triangle me-2"></i>Recent Open Incidents</span>
                    <a href="{{ route('incidents.index') }}" class="btn btn-secondary btn-sm">View All</a>
                </div>
                <div class="card-body">
                    @if($openIncidents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Asset</th>
                                        <th>Title</th>
                                        <th>Severity</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($openIncidents as $incident)
                                        <tr>
                                            <td>
                                                <a href="{{ route('assets.show', $incident->asset_id) }}">
                                                    {{ $incident->asset->asset_id }}
                                                </a>
                                            </td>
                                            <td>{{ Str::limit($incident->title, 30) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $incident->severity->color() }}">
                                                    {{ $incident->severity->label() }}
                                                </span>
                                            </td>
                                            <td>{{ $incident->incident_date->format('d M') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $incident->status->color() }}">
                                                    {{ $incident->status->label() }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-check-circle fs-1"></i>
                            <p class="mt-2 mb-0">No open incidents</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-pie-chart me-2"></i>Asset by Status
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="bi bi-circle-fill text-success me-2"
                                    style="font-size: 8px;"></i>Available</span>
                            <span class="fw-semibold">{{ $assetStats['available'] }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success"
                                style="width: {{ $assetStats['total'] > 0 ? ($assetStats['available'] / $assetStats['total'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="bi bi-circle-fill text-primary me-2" style="font-size: 8px;"></i>In Use</span>
                            <span class="fw-semibold">{{ $assetStats['in_use'] }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary"
                                style="width: {{ $assetStats['total'] > 0 ? ($assetStats['in_use'] / $assetStats['total'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="bi bi-circle-fill text-warning me-2"
                                    style="font-size: 8px;"></i>Maintenance</span>
                            <span class="fw-semibold">{{ $assetStats['maintenance'] }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning"
                                style="width: {{ $assetStats['total'] > 0 ? ($assetStats['maintenance'] / $assetStats['total'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="bi bi-circle-fill text-secondary me-2"
                                    style="font-size: 8px;"></i>Retired</span>
                            <span class="fw-semibold">{{ $assetStats['retired'] }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-secondary"
                                style="width: {{ $assetStats['total'] > 0 ? ($assetStats['retired'] / $assetStats['total'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Category & Department Distribution -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-tags me-2"></i>Assets by Category
                </div>
                <div class="card-body">
                    @if($assetsByCategory->count() > 0)
                        @foreach($assetsByCategory as $category)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-folder text-dark"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $category->name }}</div>
                                        <small class="text-muted">{{ $category->assets_count }} assets</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    @php $percent = $assetStats['total'] > 0 ? round($category->assets_count / $assetStats['total'] * 100) : 0; @endphp
                                    <span class="badge bg-warning text-dark">{{ $percent }}%</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">No categories yet</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-building me-2"></i>Assets by Department
                </div>
                <div class="card-body">
                    @if($assetsByDepartment->count() > 0)
                        @foreach($assetsByDepartment as $dept)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-people text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $dept->name }}</div>
                                        <small class="text-muted">{{ $dept->assets_count }} active assignments</small>
                                    </div>
                                </div>
                                <div>
                                    <span class="badge bg-primary">{{ $dept->assets_count }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">No assignments yet</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Row 4: Recent Activities & Warranty -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-arrow-left-right me-2"></i>Recent Assignments
                </div>
                <div class="card-body p-0">
                    @if($recentAssignments->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($recentAssignments as $assignment)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="{{ route('assets.show', $assignment->asset) }}"
                                                class="fw-semibold text-decoration-none">
                                                {{ $assignment->asset->asset_id }}
                                            </a>
                                            <div class="small text-muted">
                                                {{ $assignment->user?->name ?? $assignment->department?->name }}
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <small
                                                class="text-muted">{{ $assignment->assigned_date?->diffForHumans() ?? '-' }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">No recent assignments</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-tools me-2"></i>Recent Maintenance
                </div>
                <div class="card-body p-0">
                    @if($recentMaintenance->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($recentMaintenance as $log)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="{{ route('assets.show', $log->asset) }}"
                                                class="fw-semibold text-decoration-none">
                                                {{ $log->asset->asset_id }}
                                            </a>
                                            <div class="small text-muted">{{ $log->type->label() }}</div>
                                        </div>
                                        <div class="text-end">
                                            <div class="small">Rp {{ number_format($log->cost, 0, ',', '.') }}</div>
                                            <small class="text-muted">{{ $log->maintenance_date->format('d M') }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">No maintenance logs</div>
                    @endif
                </div>
                <div class="card-footer bg-transparent border-top">
                    <div class="row text-center">
                        <div class="col-6">
                            <h5 class="mb-0">{{ $maintenanceStats['total_logs'] }}</h5>
                            <small class="text-muted">Total Logs</small>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-0">Rp {{ number_format($maintenanceStats['total_cost'] / 1000000, 1) }}M</h5>
                            <small class="text-muted">Total Cost</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-shield-exclamation me-2"></i>Warranty Expiring</span>
                    <span class="badge bg-danger">{{ $warrantyExpiring->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($warrantyExpiring->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($warrantyExpiring as $asset)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="{{ route('assets.show', $asset) }}" class="fw-semibold text-decoration-none">
                                                {{ $asset->asset_id }}
                                            </a>
                                            <div class="small text-muted">{{ $asset->name }}</div>
                                        </div>
                                        <div class="text-end">
                                            @php $daysLeft = ceil(now()->diffInHours($asset->warranty_end_date) / 24); @endphp
                                            <span class="badge {{ $daysLeft <= 7 ? 'bg-danger' : 'bg-warning text-dark' }}">
                                                {{ $daysLeft }} days
                                            </span>
                                            <div class="small text-muted">{{ $asset->warranty_end_date->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-shield-check fs-1"></i>
                            <p class="mt-2 mb-0">No warranties expiring soon</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Row 5: Monthly Trend -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-graph-up me-2"></i>Asset Additions (Last 6 Months)
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-end justify-content-between" style="height: 150px;">
                        @php
                            $maxCount = $monthlyTrend->max('count') ?: 1;
                        @endphp
                        @forelse($monthlyTrend as $data)
                            <div class="text-center flex-fill px-2">
                                <div class="bg-warning rounded mb-2 mx-auto"
                                    style="width: 40px; height: {{ ($data->count / $maxCount) * 100 }}px; min-height: 10px;">
                                </div>
                                <div class="fw-semibold">{{ $data->count }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($data->month . '-01')->format('M') }}</small>
                            </div>
                        @empty
                            <div class="text-center w-100 text-muted py-4">
                                No data available
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection