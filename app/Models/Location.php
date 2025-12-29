<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'building',
        'floor',
        'room',
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->building,
            $this->floor ? "Floor {$this->floor}" : null,
            $this->room ? "Room {$this->room}" : null,
        ]);

        return $this->name . ($parts ? ' - ' . implode(', ', $parts) : '');
    }
}
