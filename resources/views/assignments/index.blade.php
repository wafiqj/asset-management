@extends('layouts.app')

@section('title', 'Assignments')
@section('page-title', 'Asset Assignments')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="bi bi-arrow-left-right me-2"></i>All Assignments
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>User</th>
                            <th>Department</th>
                            <th>Assigned Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            <th>Assigned By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                            <tr>
                                <td>
                                    <a href="{{ route('assets.show', $assignment->asset_id) }}">
                                        {{ $assignment->asset->asset_id }}
                                    </a>
                                </td>
                                <td>{{ $assignment->user?->name ?? '-' }}</td>
                                <td>{{ $assignment->department->name }}</td>
                                <td>{{ $assignment->assigned_date->format('d M Y') }}</td>
                                <td>{{ $assignment->return_date?->format('d M Y') ?? '-' }}</td>
                                <td>
                                    @if($assignment->isActive())
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Returned</span>
                                    @endif
                                </td>
                                <td>{{ $assignment->assignedBy->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No assignments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $assignments->links() }}
        </div>
    </div>
@endsection