@extends('layouts.app')

@section('title', 'Incidents')
@section('page-title', 'Incident Reports')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-exclamation-triangle me-2"></i>All Incidents</span>
            <div class="d-flex gap-2">
                <a href="{{ route('export.incidents') }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-download me-1"></i>Export CSV
                </a>
                @if(auth()->user()->hasPermission('incidents.create'))
                    <a href="{{ route('incidents.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Report Incident
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
                            <th>Title</th>
                            <th>Severity</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Reported By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incidents as $incident)
                            <tr>
                                <td>
                                    <a href="{{ route('assets.show', $incident->asset_id) }}">
                                        {{ $incident->asset->asset_id }}
                                    </a>
                                </td>
                                <td>{{ Str::limit($incident->title, 40) }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $incident->severity->color() }}">{{ $incident->severity->label() }}</span>
                                </td>
                                <td>{{ $incident->incident_date->format('d M Y') }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $incident->status->color() }}">{{ $incident->status->label() }}</span>
                                </td>
                                <td>{{ $incident->reportedBy->name }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('incidents.show', $incident) }}" class="btn btn-outline-secondary"
                                            title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->hasPermission('incidents.edit'))
                                            <a href="{{ route('incidents.edit', $incident) }}" class="btn btn-outline-primary"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No incidents found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $incidents->links() }}
        </div>
    </div>
@endsection