@extends('layouts.app')

@section('title', 'Report Incident')
@section('page-title', 'Report New Incident')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="bi bi-plus-lg me-2"></i>New Incident Report
        </div>
        <div class="card-body">
            <form action="{{ route('incidents.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Asset <span class="text-danger">*</span></label>
                        <select name="asset_id" class="form-select @error('asset_id') is-invalid @enderror" required>
                            <option value="">Select Asset</option>
                            @foreach($assets as $a)
                                <option value="{{ $a->id }}" {{ (old('asset_id') == $a->id || ($asset && $asset->id == $a->id)) ? 'selected' : '' }}>
                                    {{ $a->asset_id }} - {{ $a->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('asset_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Severity <span class="text-danger">*</span></label>
                        <select name="severity" class="form-select @error('severity') is-invalid @enderror" required>
                            @foreach($severities as $severity)
                                <option value="{{ $severity->value }}">{{ $severity->label() }}</option>
                            @endforeach
                        </select>
                        @error('severity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Incident Date <span class="text-danger">*</span></label>
                        <input type="date" name="incident_date"
                            class="form-control @error('incident_date') is-invalid @enderror"
                            value="{{ old('incident_date', now()->format('Y-m-d')) }}" required>
                        @error('incident_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-check-lg me-1"></i>Submit Report
                    </button>
                    <a href="{{ route('incidents.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection