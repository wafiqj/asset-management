<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('login', function () {
        $credentials = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, request()->boolean('remember'))) {
            request()->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    });
});

Route::post('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Assets
    Route::resource('assets', AssetController::class);

    // Assignments
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assets/{asset}/assign', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assets/{asset}/assign', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/assets/{asset}/return', [AssignmentController::class, 'returnForm'])->name('assignments.return');
    Route::post('/assets/{asset}/return', [AssignmentController::class, 'return'])->name('assignments.return.store');
    Route::get('/assets/{asset}/history', [AssignmentController::class, 'history'])->name('assignments.history');

    // Maintenance
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/create/{asset?}', [MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
    Route::get('/maintenance/{maintenance}', [MaintenanceController::class, 'show'])->name('maintenance.show');

    // Incidents
    Route::resource('incidents', IncidentController::class)->except(['destroy']);
    Route::post('/incidents/{incident}/resolve', [IncidentController::class, 'resolve'])->name('incidents.resolve');

    // Categories
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Locations
    Route::resource('locations', LocationController::class)->except(['show']);

    // Departments
    Route::resource('departments', DepartmentController::class)->except(['show']);

    // Users (Admin only)
    Route::middleware('permission:users.view')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    // Audit Trail
    Route::get('/audit-trail', [AuditLogController::class, 'index'])->name('audit.index');

    // Export
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/assets', [ExportController::class, 'assets'])->name('assets');
        Route::get('/maintenance', [ExportController::class, 'maintenance'])->name('maintenance');
        Route::get('/incidents', [ExportController::class, 'incidents'])->name('incidents');
    });
});
