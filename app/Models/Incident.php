<?php

namespace App\Models;

use App\Enums\IncidentSeverity;
use App\Enums\IncidentStatus;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incident extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'asset_id',
        'title',
        'description',
        'incident_date',
        'status',
        'severity',
        'reported_by',
        'resolved_by',
        'resolved_date',
        'resolution_notes',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'resolved_date' => 'date',
        'status' => IncidentStatus::class,
        'severity' => IncidentSeverity::class,
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function isOpen(): bool
    {
        return in_array($this->status, [IncidentStatus::OPEN, IncidentStatus::IN_PROGRESS]);
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', [IncidentStatus::OPEN, IncidentStatus::IN_PROGRESS]);
    }
}
