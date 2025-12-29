<?php

namespace App\Http\Requests\Asset;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        // API requests (via API key) don't have user session, allow if route is API
        if ($this->is('api/*')) {
            return true;
        }

        return $this->user()?->hasPermission('assets.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255', 'unique:assets,serial_number'],
            'purchase_date' => ['nullable', 'date'],
            'warranty_end_date' => ['nullable', 'date', 'after_or_equal:purchase_date'],
            'asset_value' => ['nullable', 'numeric', 'min:0'],
            'location_id' => ['nullable', 'exists:locations,id'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama asset wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'serial_number.unique' => 'Serial number sudah terdaftar.',
            'warranty_end_date.after_or_equal' => 'Tanggal warranty harus setelah tanggal pembelian.',
        ];
    }
}
