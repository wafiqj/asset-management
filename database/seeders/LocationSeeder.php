<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Head Office', 'building' => 'Main Building', 'floor' => '1', 'room' => 'IT Room'],
            ['name' => 'Head Office', 'building' => 'Main Building', 'floor' => '2', 'room' => 'Server Room'],
            ['name' => 'Branch Office A', 'building' => 'Branch A', 'floor' => '1', 'room' => null],
            ['name' => 'Branch Office B', 'building' => 'Branch B', 'floor' => '1', 'room' => null],
            ['name' => 'Warehouse', 'building' => 'Storage', 'floor' => null, 'room' => 'IT Storage'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
