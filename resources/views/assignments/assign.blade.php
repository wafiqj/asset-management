@extends('layouts.app')

@section('title', 'Assign Asset')
@section('page-title', 'Assign Asset: ' . $asset->asset_id)

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="bi bi-person-plus me-2"></i>Assign Asset to User/Department
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <strong>Asset:</strong> {{ $asset->asset_id }} - {{ $asset->name }}
            </div>

            <form action="{{ route('assignments.store', $asset) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Assign to User</label>
                        <select name="user_id" class="form-select">
                            <option value="">Select User (Optional)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Department <span class="text-danger">*</span></label>
                        <select name="department_id" class="form-select @error('department_id') is-invalid @enderror"
                            required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }} ({{ $department->code }})</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Assigned Date <span class="text-danger">*</span></label>
                        <input type="date" name="assigned_date"
                            class="form-control @error('assigned_date') is-invalid @enderror"
                            value="{{ old('assigned_date', now()->format('Y-m-d')) }}" required>
                        @error('assigned_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i>Assign Asset
                    </button>
                    <a href="{{ route('assets.show', $asset) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection