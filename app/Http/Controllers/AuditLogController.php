<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\AuditLogRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function __construct(
        protected AuditLogRepositoryInterface $repository
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['user_id', 'action', 'auditable_type', 'start_date', 'end_date']);
        $logs = $this->repository->paginate(20, $filters);

        return view('reports.audit-trail', compact('logs', 'filters'));
    }
}
