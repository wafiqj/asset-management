@extends('layouts.app')

@section('title', $asset->asset_id)
@section('page-title', 'Asset Details')

@section('content')
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-info-circle me-2"></i>Asset Information</span>
                    <div class="d-flex gap-2">
                        @if($asset->isAvailable() && auth()->user()->hasPermission('assignments.create'))
                            <a href="{{ route('assignments.create', $asset) }}" class="btn btn-success btn-sm text-light">
                                <i class="bi bi-person-plus me-1"></i>Assign
                            </a>
                        @endif
                        @if(!$asset->isAvailable() && auth()->user()->hasPermission('assignments.return'))
                            <a href="{{ route('assignments.return', $asset) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-arrow-return-left me-1"></i>Return
                            </a>
                        @endif
                        @if(auth()->user()->hasPermission('assets.edit'))
                            <a href="{{ route('assets.edit', $asset) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Asset ID</th>
                                    <td><strong>{{ $asset->asset_id }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $asset->name }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ $asset->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Brand</th>
                                    <td>{{ $asset->brand ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Model</th>
                                    <td>{{ $asset->model ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Serial Number</th>
                                    <td><code>{{ $asset->serial_number ?? '-' }}</code></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Status</th>
                                    <td>
                                        <span class="badge bg-{{ $asset->status->color() }}">
                                            {{ $asset->status->label() }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td>{{ $asset->location?->full_address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Purchase Date</th>
                                    <td>{{ $asset->purchase_date?->format('d M Y') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Warranty</th>
                                    <td>
                                        @if($asset->warranty_end_date)
                                            {{ $asset->warranty_end_date->format('d M Y') }}
                                            @if($asset->isUnderWarranty())
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Expired</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Asset Value</th>
                                    <td>Rp {{ number_format($asset->asset_value, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @if($asset->notes)
                        <div class="mt-3">
                            <strong>Notes:</strong>
                            <p class="mb-0">{{ $asset->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Assignment History -->
            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-clock-history me-2"></i>Assignment History
                </div>
                <div class="card-body p-0">
                    @if($asset->assignments->count() > 0)
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Department</th>
                                        <th>Assigned Date</th>
                                        <th>Return Date</th>
                                        <th>Assigned By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asset->assignments as $assignment)
                                        <tr>
                                            <td>{{ $assignment->user?->name ?? '-' }}</td>
                                            <td>{{ $assignment->department->name }}</td>
                                            <td>{{ $assignment->assigned_date->format('d M Y') }}</td>
                                            <td>{{ $assignment->return_date?->format('d M Y') ?? '-' }}</td>
                                            <td>{{ $assignment->assignedBy->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">No assignment history</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-lightning me-2"></i>Quick Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('maintenance.create', $asset) }}" class="btn btn-outline-primary">
                            <i class="bi bi-tools me-2"></i>Add Maintenance Log
                        </a>
                        <a href="{{ route('incidents.create', $asset) }}" class="btn btn-outline-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>Report Incident
                        </a>
                    </div>
                </div>
            </div>

            <!-- Maintenance Logs -->
            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-tools me-2"></i>Recent Maintenance
                </div>
                <div class="card-body">
                    @forelse($asset->maintenanceLogs->take(3) as $log)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-{{ $log->type->color() }}">{{ $log->type->label() }}</span>
                                <small class="text-muted">{{ $log->maintenance_date->format('d M Y') }}</small>
                            </div>
                            <p class="mb-1 mt-2">{{ Str::limit($log->description, 80) }}</p>
                            <small class="text-muted">Cost: Rp {{ number_format($log->cost, 0, ',', '.') }}</small>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No maintenance logs</p>
                    @endforelse
                </div>
            </div>

            <!-- Incidents -->
            <div class="card mt-4">
                <div class="card-header">
                    <i class="bi bi-exclamation-triangle me-2"></i>Recent Incidents
                </div>
                <div class="card-body">
                    @forelse($asset->incidents->take(3) as $incident)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-{{ $incident->status->color() }}">{{ $incident->status->label() }}</span>
                                <span
                                    class="badge bg-{{ $incident->severity->color() }}">{{ $incident->severity->label() }}</span>
                            </div>
                            <p class="mb-1 mt-2"><strong>{{ $incident->title }}</strong></p>
                            <small class="text-muted">{{ $incident->incident_date->format('d M Y') }}</small>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No incidents reported</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection