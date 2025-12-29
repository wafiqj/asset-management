<?php

namespace App\Http\Requests\Maintenance;

use App\Enums\MaintenanceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('maintenance.create');
    }

    public function rules(): array
    {
        return [
            'asset_id' => ['required', 'exists:assets,id'],
            'type' => ['required', Rule::enum(MaintenanceType::class)],
            'vendor' => ['nullable', 'string', 'max:255'],
            'pic' => ['required', 'string', 'max:255'],
            'maintenance_date' => ['required', 'date'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'asset_id.required' => 'Asset wajib dipilih.',
            'type.required' => 'Tipe maintenance wajib dipilih.',
            'pic.required' => 'PIC wajib diisi.',
            'maintenance_date.required' => 'Tanggal maintenance wajib diisi.',
            'description.required' => 'Deskripsi maintenance wajib diisi.',
        ];
    }
}
