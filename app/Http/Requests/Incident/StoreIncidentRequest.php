<?php

namespace App\Http\Requests\Incident;

use App\Enums\IncidentSeverity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIncidentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('incidents.create');
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'incident_date' => ['required', 'date'],
            'severity' => ['required', Rule::enum(IncidentSeverity::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.required' => 'Asset wajib dipilih.',
            'title.required' => 'Judul incident wajib diisi.',
            'description.required' => 'Deskripsi incident wajib diisi.',
            'incident_date.required' => 'Tanggal incident wajib diisi.',
            'severity.required' => 'Severity wajib dipilih.',
        ];
    }
}
