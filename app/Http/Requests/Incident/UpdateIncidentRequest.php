<?php

namespace App\Http\Requests\Incident;

use App\Enums\IncidentSeverity;
use App\Enums\IncidentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIncidentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('incidents.edit');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'incident_date' => ['required', 'date'],
            'status' => ['required', Rule::enum(IncidentStatus::class)],
            'severity' => ['required', Rule::enum(IncidentSeverity::class)],
            'resolution_notes' => ['nullable', 'string'],
        ];
    }
}
