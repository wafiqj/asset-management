@extends('layouts.app')

@section('title', 'Incident Details')
@section('page-title', 'Incident Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-exclamation-triangle me-2"></i>Incident #{{ $incident->id }}</span>
            <div class="d-flex gap-2">
                @if($incident->isOpen() && auth()->user()->hasPermission('incidents.edit'))
                    <form action="{{ route('incidents.resolve', $incident) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-check-circle me-1"></i>Mark Resolved
                        </button>
                    </form>
                    <a href="{{ route('incidents.edit', $incident) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4>{{ $incident->title }}</h4>
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge bg-{{ $incident->severity->color() }}">{{ $incident->severity->label() }}</span>
                        <span class="badge bg-{{ $incident->status->color() }}">{{ $incident->status->label() }}</span>
                    </div>
                    <p>{{ $incident->description }}</p>

                    @if($incident->resolution_notes)
                        <div class="alert alert-success mt-4">
                            <h6><i class="bi bi-check-circle me-2"></i>Resolution Notes</h6>
                            <p class="mb-0">{{ $incident->resolution_notes }}</p>
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <table class="table table-borderless">
                        <tr>
                            <th>Asset</th>
                            <td><a
                                    href="{{ route('assets.show', $incident->asset_id) }}">{{ $incident->asset->asset_id }}</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $incident->incident_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Reported By</th>
                            <td>{{ $incident->reportedBy->name }}</td>
                        </tr>
                        @if($incident->resolved_by)
                            <tr>
                                <th>Resolved By</th>
                                <td>{{ $incident->resolvedBy->name }}</td>
                            </tr>
                            <tr>
                                <th>Resolved Date</th>
                                <td>{{ $incident->resolved_date->format('d M Y') }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection