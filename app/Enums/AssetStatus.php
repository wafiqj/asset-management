<?php

namespace App\Enums;

enum AssetStatus: string
{
    case AVAILABLE = 'Available';
    case IN_USE = 'In Use';
    case MAINTENANCE = 'Maintenance';
    case RETIRED = 'Retired';

    public function label(): string
    {
        return $this->value;
    }

    public function color(): string
    {
        return match ($this) {
            self::AVAILABLE => 'success',
            self::IN_USE => 'primary',
            self::MAINTENANCE => 'warning',
            self::RETIRED => 'secondary',
        };
    }
}
