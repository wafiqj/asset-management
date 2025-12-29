<?php

namespace App\Http\Requests\Asset;

use App\Enums\AssetStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        // API requests (via API key) don't have user session, allow if route is API
        if ($this->is('api/*')) {
            return true;
        }

        return $this->user()?->hasPermission('assets.edit') ?? false;
    }

    public function rules(): array
    {
        $assetId = $this->route('asset')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'serial_number' => ['nullable', 'string', 'max:255', Rule::unique('assets')->ignore($assetId)],
            'purchase_date' => ['nullable', 'date'],
            'warranty_end_date' => ['nullable', 'date', 'after_or_equal:purchase_date'],
            'asset_value' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', Rule::enum(AssetStatus::class)],
            'location_id' => ['nullable', 'exists:locations,id'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama asset wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'serial_number.unique' => 'Serial number sudah terdaftar.',
        ];
    }
}
