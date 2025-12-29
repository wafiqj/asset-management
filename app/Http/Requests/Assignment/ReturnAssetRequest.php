<?php

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class ReturnAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasPermission('assignments.return');
    }

    public function rules(): array
    {
        return [
            'return_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'return_date.required' => 'Tanggal return wajib diisi.',
        ];
    }
}
