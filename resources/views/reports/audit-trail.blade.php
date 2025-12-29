@extends('layouts.app')

@section('title', 'Audit Trail')
@section('page-title', 'Audit Trail')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="bi bi-journal-text me-2"></i>Audit Log
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Resource</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d M Y H:i:s') }}</td>
                                <td>{{ $log->user->name }}</td>
                                <td>
                                    @php
                                        $actionColors = [
                                            'create' => 'success',
                                            'update' => 'primary',
                                            'delete' => 'danger',
                                            'assign' => 'info',
                                            'return' => 'warning',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $actionColors[$log->action] ?? 'secondary' }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</small>
                                </td>
                                <td>
                                    @if($log->changes)
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $log->id }}">
                                            View Changes
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modal-{{ $log->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Change Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Field</th>
                                                                    <th>Old Value</th>
                                                                    <th>New Value</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($log->changes as $field => $change)
                                                                    <tr>
                                                                        <td>{{ $field }}</td>
                                                                        <td><code>{{ json_encode($change['old']) }}</code></td>
                                                                        <td><code>{{ json_encode($change['new']) }}</code></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No audit logs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $logs->links() }}
        </div>
    </div>
@endsection