<?php

namespace App\Enums;

enum MaintenanceType: string
{
    case PREVENTIVE = 'Preventive';
    case CORRECTIVE = 'Corrective';
    case UPGRADE = 'Upgrade';

    public function label(): string
    {
        return $this->value;
    }

    public function color(): string
    {
        return match ($this) {
            self::PREVENTIVE => 'info',
            self::CORRECTIVE => 'warning',
            self::UPGRADE => 'success',
        };
    }
}
