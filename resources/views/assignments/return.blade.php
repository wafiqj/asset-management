@extends('layouts.app')

@section('title', 'Return Asset')
@section('page-title', 'Return Asset: ' . $asset->asset_id)

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="bi bi-arrow-return-left me-2"></i>Return Asset
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                <strong>Asset:</strong> {{ $asset->asset_id }} - {{ $asset->name }}<br>
                <strong>Currently Assigned To:</strong> {{ $currentAssignment->user?->name ?? 'N/A' }}
                ({{ $currentAssignment->department->name }})<br>
                <strong>Assigned Date:</strong> {{ $currentAssignment->assigned_date->format('d M Y') }}
            </div>

            <form action="{{ route('assignments.return.store', $asset) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Return Date <span class="text-danger">*</span></label>
                        <input type="date" name="return_date"
                            class="form-control @error('return_date') is-invalid @enderror"
                            value="{{ old('return_date', now()->format('Y-m-d')) }}" required>
                        @error('return_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-lg me-1"></i>Return Asset
                    </button>
                    <a href="{{ route('assets.show', $asset) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection