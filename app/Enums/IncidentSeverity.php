<?php

namespace App\Enums;

enum IncidentSeverity: string
{
    case LOW = 'Low';
    case MEDIUM = 'Medium';
    case HIGH = 'High';
    case CRITICAL = 'Critical';

    public function label(): string
    {
        return $this->value;
    }

    public function color(): string
    {
        return match ($this) {
            self::LOW => 'info',
            self::MEDIUM => 'warning',
            self::HIGH => 'danger',
            self::CRITICAL => 'dark',
        };
    }
}
