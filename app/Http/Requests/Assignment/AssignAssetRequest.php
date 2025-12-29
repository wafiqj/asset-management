<?php

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class AssignAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('assignments.create');
    }

    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'exists:users,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'assigned_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'department_id.required' => 'Department wajib dipilih.',
            'department_id.exists' => 'Department tidak valid.',
            'assigned_date.required' => 'Tanggal assign wajib diisi.',
        ];
    }
}
