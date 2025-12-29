@extends('layouts.app')

@section('title', 'Add Maintenance Log')
@section('page-title', 'Add Maintenance Log')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="bi bi-plus-lg me-2"></i>New Maintenance Log
        </div>
        <div class="card-body">
            <form action="{{ route('maintenance.store') }}" method="POST">
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
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            @foreach($types as $type)
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Vendor</label>
                        <input type="text" name="vendor" class="form-control" value="{{ old('vendor') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">PIC (Person in Charge) <span class="text-danger">*</span></label>
                        <input type="text" name="pic" class="form-control @error('pic') is-invalid @enderror"
                            value="{{ old('pic') }}" required>
                        @error('pic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Maintenance Date <span class="text-danger">*</span></label>
                        <input type="date" name="maintenance_date"
                            class="form-control @error('maintenance_date') is-invalid @enderror"
                            value="{{ old('maintenance_date', now()->format('Y-m-d')) }}" required>
                        @error('maintenance_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Cost (Rp)</label>
                        <input type="number" name="cost" class="form-control" value="{{ old('cost', 0) }}" min="0">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Save Log
                    </button>
                    <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection