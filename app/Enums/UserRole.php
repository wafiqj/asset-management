<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'Admin';
    case INFRA_STAFF = 'Infra Staff';
    case VIEWER = 'Viewer';

    public function label(): string
    {
        return $this->value;
    }

    public function permissions(): array
    {
        return match ($this) {
            self::ADMIN => [
                'assets.view',
                'assets.create',
                'assets.edit',
                'assets.delete',
                'assignments.view',
                'assignments.create',
                'assignments.return',
                'maintenance.view',
                'maintenance.create',
                'incidents.view',
                'incidents.create',
                'incidents.edit',
                'users.view',
                'users.create',
                'users.edit',
                'users.delete',
                'roles.view',
                'roles.manage',
                'categories.manage',
                'locations.manage',
                'departments.manage',
                'audit.view',
                'export.all',
            ],
            self::INFRA_STAFF => [
                'assets.view',
                'assets.create',
                'assets.edit',
                'assignments.view',
                'assignments.create',
                'assignments.return',
                'maintenance.view',
                'maintenance.create',
                'incidents.view',
                'incidents.create',
                'incidents.edit',
                'categories.manage',
                'locations.manage',
                'audit.view',
                'export.all',
            ],
            self::VIEWER => [
                'assets.view',
                'assignments.view',
                'maintenance.view',
                'incidents.view',
                'export.all',
            ],
        };
    }
}
