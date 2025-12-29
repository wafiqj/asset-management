<?php

namespace App\Models;

use App\Enums\AssetStatus;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Carbon|null $purchase_date
 * @property Carbon|null $warranty_end_date
 */
class Asset extends Model
{
    use HasFactory, SoftDeletes, Auditable;

    protected $fillable = [
        'asset_id',
        'name',
        'category_id',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'warranty_end_date',
        'asset_value',
        'status',
        'location_id',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_end_date' => 'date',
        'asset_value' => 'decimal:2',
        'status' => AssetStatus::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class);
    }

    public function currentAssignment()
    {
        return $this->hasOne(AssetAssignment::class)
            ->whereNull('return_date')
            ->latest('assigned_date');
    }

    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === AssetStatus::AVAILABLE;
    }

    public function isUnderWarranty(): bool
    {
        return $this->warranty_end_date && $this->warranty_end_date->isFuture();
    }

    public function scopeSearch($query, ?string $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('asset_id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function scopeStatus($query, ?string $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function scopeCategory($query, ?int $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }

        return $query;
    }

    public function scopeLocation($query, ?int $locationId)
    {
        if ($locationId) {
            return $query->where('location_id', $locationId);
        }

        return $query;
    }
}
