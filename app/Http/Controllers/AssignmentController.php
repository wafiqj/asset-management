<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assignment\AssignAssetRequest;
use App\Http\Requests\Assignment\ReturnAssetRequest;
use App\Models\Asset;
use App\Models\Department;
use App\Models\User;
use App\Services\AssignmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function __construct(
        protected AssignmentService $assignmentService
    ) {
    }

    public function index(): View
    {
        $assignments = $this->assignmentService->getPaginatedAssignments();

        return view('assignments.index', compact('assignments'));
    }

    public function create(Asset $asset): View|RedirectResponse
    {
        if (!$asset->isAvailable()) {
            return redirect()->route('assets.show', $asset)
                ->with('error', 'Asset tidak tersedia untuk di-assign.');
        }

        $users = User::all();
        $departments = Department::all();

        return view('assignments.assign', compact('asset', 'users', 'departments'));
    }

    public function store(AssignAssetRequest $request, Asset $asset): RedirectResponse
    {
        try {
            $this->assignmentService->assignAsset($asset, $request->validated());

            return redirect()->route('assets.show', $asset)
                ->with('success', 'Asset berhasil di-assign.');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function returnForm(Asset $asset): View|RedirectResponse
    {
        $currentAssignment = $asset->currentAssignment;

        if (!$currentAssignment) {
            return redirect()->route('assets.show', $asset)
                ->with('error', 'Asset tidak memiliki assignment aktif.');
        }

        return view('assignments.return', compact('asset', 'currentAssignment'));
    }

    public function return(ReturnAssetRequest $request, Asset $asset): RedirectResponse
    {
        try {
            $this->assignmentService->returnAsset($asset, $request->validated());

            return redirect()->route('assets.show', $asset)
                ->with('success', 'Asset berhasil di-return.');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function history(Asset $asset): View
    {
        $history = $this->assignmentService->getAssetHistory($asset->id);

        return view('assignments.history', compact('asset', 'history'));
    }
}
