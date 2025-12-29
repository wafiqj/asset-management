<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptop', 'description' => 'Portable computing devices'],
            ['name' => 'Desktop', 'description' => 'Desktop computers and workstations'],
            ['name' => 'Monitor', 'description' => 'Display monitors'],
            ['name' => 'Printer', 'description' => 'Printers and scanners'],
            ['name' => 'Network Equipment', 'description' => 'Routers, switches, access points'],
            ['name' => 'Server', 'description' => 'Physical and virtual servers'],
            ['name' => 'Storage', 'description' => 'NAS, SAN, external drives'],
            ['name' => 'Peripheral', 'description' => 'Keyboards, mice, headsets'],
            ['name' => 'Software License', 'description' => 'Software licenses and subscriptions'],
            ['name' => 'Other', 'description' => 'Other IT equipment'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
