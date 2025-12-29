<?php

namespace App\Http\Controllers;

use App\Enums\IncidentSeverity;
use App\Enums\IncidentStatus;
use App\Http\Requests\Incident\StoreIncidentRequest;
use App\Http\Requests\Incident\UpdateIncidentRequest;
use App\Models\Asset;
use App\Models\Incident;
use App\Services\IncidentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncidentController extends Controller
{
    public function __construct(
        protected IncidentService $incidentService
    ) {
    }

    public function index(): View
    {
        $incidents = $this->incidentService->getPaginatedIncidents();

        return view('incidents.index', compact('incidents'));
    }

    public function create(?Asset $asset = null): View
    {
        $assets = Asset::all();
        $severities = IncidentSeverity::cases();

        return view('incidents.create', compact('assets', 'severities', 'asset'));
    }

    public function store(StoreIncidentRequest $request): RedirectResponse
    {
        $incident = $this->incidentService->createIncident($request->validated());

        return redirect()->route('incidents.show', $incident)
            ->with('success', 'Incident berhasil dilaporkan.');
    }

    public function show(Incident $incident): View
    {
        $incident->load(['asset', 'reportedBy', 'resolvedBy']);

        return view('incidents.show', compact('incident'));
    }

    public function edit(Incident $incident): View
    {
        $statuses = IncidentStatus::cases();
        $severities = IncidentSeverity::cases();

        return view('incidents.edit', compact('incident', 'statuses', 'severities'));
    }

    public function update(UpdateIncidentRequest $request, Incident $incident): RedirectResponse
    {
        $this->incidentService->updateIncident($incident, $request->validated());

        return redirect()->route('incidents.show', $incident)
            ->with('success', 'Incident berhasil diperbarui.');
    }

    public function resolve(Request $request, Incident $incident): RedirectResponse
    {
        $request->validate([
            'resolution_notes' => 'nullable|string',
        ]);

        $this->incidentService->resolveIncident($incident, $request->only('resolution_notes'));

        return redirect()->route('incidents.show', $incident)
            ->with('success', 'Incident berhasil diselesaikan.');
    }
}
