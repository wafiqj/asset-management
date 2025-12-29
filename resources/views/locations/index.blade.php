@extends('layouts.app')

@section('title', 'Locations')
@section('page-title', 'Locations')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-geo-alt me-2"></i>Locations</span>
            @if(auth()->user()->hasPermission('locations.manage'))
                <a href="{{ route('locations.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Add Location
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Building</th>
                            <th>Floor</th>
                            <th>Room</th>
                            <th>Assets Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($locations as $location)
                            <tr>
                                <td>{{ $location->name }}</td>
                                <td>{{ $location->building ?? '-' }}</td>
                                <td>{{ $location->floor ?? '-' }}</td>
                                <td>{{ $location->room ?? '-' }}</td>
                                <td>{{ $location->assets_count }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('locations.edit', $location) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('locations.destroy', $location) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No locations found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $locations->links() }}
        </div>
    </div>
@endsection