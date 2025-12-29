@extends('layouts.app')

@section('title', 'Edit Location')
@section('page-title', 'Edit Location')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="bi bi-pencil me-2"></i>Edit Location
        </div>
        <div class="card-body">
            <form action="{{ route('locations.update', $location) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $location->name) }}"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Building</label>
                        <input type="text" name="building" class="form-control"
                            value="{{ old('building', $location->building) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Floor</label>
                        <input type="text" name="floor" class="form-control" value="{{ old('floor', $location->floor) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Room</label>
                        <input type="text" name="room" class="form-control" value="{{ old('room', $location->room) }}">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Update Location
                    </button>
                    <a href="{{ route('locations.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection