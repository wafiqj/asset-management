@extends('layouts.app')

@section('title', 'Edit Incident')
@section('page-title', 'Edit Incident')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="bi bi-pencil me-2"></i>Edit Incident
        </div>
        <div class="card-body">
            <form action="{{ route('incidents.update', $incident) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ $incident->status == $status ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Severity <span class="text-danger">*</span></label>
                        <select name="severity" class="form-select" required>
                            @foreach($severities as $severity)
                                <option value="{{ $severity->value }}" {{ $incident->severity == $severity ? 'selected' : '' }}>
                                    {{ $severity->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $incident->title) }}"
                            required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Incident Date <span class="text-danger">*</span></label>
                        <input type="date" name="incident_date" class="form-control"
                            value="{{ old('incident_date', $incident->incident_date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="4"
                            required>{{ old('description', $incident->description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Resolution Notes</label>
                        <textarea name="resolution_notes" class="form-control"
                            rows="3">{{ old('resolution_notes', $incident->resolution_notes) }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Update Incident
                    </button>
                    <a href="{{ route('incidents.show', $incident) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection