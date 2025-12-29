@extends('layouts.app')

@section('title', 'Add Location')
@section('page-title', 'Add Location')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="bi bi-plus-lg me-2"></i>New Location
        </div>
        <div class="card-body">
            <form action="{{ route('locations.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Building</label>
                        <input type="text" name="building" class="form-control" value="{{ old('building') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Floor</label>
                        <input type="text" name="floor" class="form-control" value="{{ old('floor') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Room</label>
                        <input type="text" name="room" class="form-control" value="{{ old('room') }}">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Save Location
                    </button>
                    <a href="{{ route('locations.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection