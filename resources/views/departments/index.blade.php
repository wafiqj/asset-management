@extends('layouts.app')

@section('title', 'Departments')
@section('page-title', 'Departments')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-building me-2"></i>Departments</span>
            @if(auth()->user()->hasPermission('departments.manage'))
                <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Add Department
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Users Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $department)
                            <tr>
                                <td><code>{{ $department->code }}</code></td>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->users_count }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('departments.edit', $department) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('departments.destroy', $department) }}" method="POST"
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
                                <td colspan="4" class="text-center py-4 text-muted">No departments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $departments->links() }}
        </div>
    </div>
@endsection