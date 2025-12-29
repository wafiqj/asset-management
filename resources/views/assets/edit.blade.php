@extends('layouts.app')

@section('title', 'Edit Asset')
@section('page-title', 'Edit Asset: ' . $asset->asset_id)

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="bi bi-pencil me-2"></i>Edit Asset
        </div>
        <div class="card-body">
            <form action="{{ route('assets.update', $asset) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Asset ID</label>
                        <input type="text" class="form-control" value="{{ $asset->asset_id }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ $asset->status == $status ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Asset Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $asset->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $asset->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" class="form-control" value="{{ old('brand', $asset->brand) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Model</label>
                        <input type="text" name="model" class="form-control" value="{{ old('model', $asset->model) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Serial Number</label>
                        <input type="text" name="serial_number"
                            class="form-control @error('serial_number') is-invalid @enderror"
                            value="{{ old('serial_number', $asset->serial_number) }}">
                        @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Purchase Date</label>
                        <input type="date" name="purchase_date" class="form-control"
                            value="{{ old('purchase_date', $asset->purchase_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Warranty End Date</label>
                        <input type="date" name="warranty_end_date"
                            class="form-control @error('warranty_end_date') is-invalid @enderror"
                            value="{{ old('warranty_end_date', $asset->warranty_end_date?->format('Y-m-d')) }}">
                        @error('warranty_end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Asset Value (Rp)</label>
                        <input type="number" name="asset_value" class="form-control"
                            value="{{ old('asset_value', $asset->asset_value) }}" min="0" step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <select name="location_id" class="form-select">
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ $asset->location_id == $location->id ? 'selected' : '' }}>
                                    {{ $location->full_address }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $asset->notes) }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Update Asset
                    </button>
                    <a href="{{ route('assets.show', $asset) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection