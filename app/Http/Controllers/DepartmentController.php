<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::withCount('users')->paginate(15);

        return view('departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('departments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code',
        ]);

        Department::create($request->only(['name', 'code']));

        return redirect()->route('departments.index')
            ->with('success', 'Department berhasil ditambahkan.');
    }

    public function edit(Department $department): View
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code,' . $department->id,
        ]);

        $department->update($request->only(['name', 'code']));

        return redirect()->route('departments.index')
            ->with('success', 'Department berhasil diperbarui.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        if ($department->users()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Department tidak bisa dihapus karena masih memiliki user.');
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department berhasil dihapus.');
    }
}
