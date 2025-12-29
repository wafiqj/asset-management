<?php

namespace App\Models;

use App\Enums\MaintenanceType;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'asset_id',
        'type',
        'vendor',
        'pic',
        'maintenance_date',
        'cost',
        'description',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'type' => MaintenanceType::class,
        'maintenance_date' => 'date',
        'cost' => 'decimal:2',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
