@extends('layouts.app')

@section('title', 'Assets')
@section('page-title', 'Asset Management')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-pc-display me-2"></i>All Assets</span>
            <div class="d-flex gap-2">
                <a href="{{ route('export.assets') }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-download me-1"></i>Export CSV
                </a>
                @if(auth()->user()->hasPermission('assets.create'))
                    <a href="{{ route('assets.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Add Asset
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by ID, name, serial..."
                        value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" {{ ($filters['status'] ?? '') == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="location_id" class="form-select">
                        <option value="">All Locations</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ ($filters['location_id'] ?? '') == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Asset ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Brand/Model</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Assigned To</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                            <tr>
                                <td><a href="{{ route('assets.show', $asset) }}">{{ $asset->asset_id }}</a></td>
                                <td>{{ $asset->name }}</td>
                                <td>{{ $asset->category->name }}</td>
                                <td>{{ $asset->brand }} {{ $asset->model }}</td>
                                <td>
                                    <span class="badge bg-{{ $asset->status->color() }}">
                                        {{ $asset->status->label() }}
                                    </span>
                                </td>
                                <td>{{ $asset->location?->name ?? '-' }}</td>
                                <td>{{ $asset->currentAssignment?->user?->name ?? '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('assets.show', $asset) }}" class="btn btn-outline-secondary"
                                            title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->hasPermission('assets.edit'))
                                            <a href="{{ route('assets.edit', $asset) }}" class="btn btn-outline-primary"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No assets found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $assets->withQueryString()->links() }}
        </div>
    </div>
@endsection