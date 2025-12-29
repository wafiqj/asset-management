<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();

        if ($adminRole) {
            User::updateOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Administrator',
                    'password' => Hash::make('password'),
                    'role_id' => $adminRole->id,
                ]
            );
        }
    }
}
