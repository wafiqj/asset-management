<?php

namespace App\Enums;

enum IncidentStatus: string
{
    case OPEN = 'Open';
    case IN_PROGRESS = 'In Progress';
    case RESOLVED = 'Resolved';
    case CLOSED = 'Closed';

    public function label(): string
    {
        return $this->value;
    }

    public function color(): string
    {
        return match ($this) {
            self::OPEN => 'danger',
            self::IN_PROGRESS => 'warning',
            self::RESOLVED => 'success',
            self::CLOSED => 'secondary',
        };
    }
}
