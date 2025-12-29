@extends('layouts.app')

@section('title', 'Maintenance Logs')
@section('page-title', 'Maintenance Logs')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-tools me-2"></i>All Maintenance Logs</span>
            <div class="d-flex gap-2">
                <a href="{{ route('export.maintenance') }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-download me-1"></i>Export CSV
                </a>
                @if(auth()->user()->hasPermission('maintenance.create'))
                    <a href="{{ route('maintenance.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Add Log
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>Type</th>
                            <th>Vendor</th>
                            <th>PIC</th>
                            <th>Date</th>
                            <th>Cost</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    <a href="{{ route('assets.show', $log->asset_id) }}">
                                        {{ $log->asset->asset_id }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $log->type->color() }}">{{ $log->type->label() }}</span>
                                </td>
                                <td>{{ $log->vendor ?? '-' }}</td>
                                <td>{{ $log->pic }}</td>
                                <td>{{ $log->maintenance_date->format('d M Y') }}</td>
                                <td>Rp {{ number_format($log->cost, 0, ',', '.') }}</td>
                                <td>{{ $log->createdBy->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No maintenance logs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $logs->links() }}
        </div>
    </div>
@endsection