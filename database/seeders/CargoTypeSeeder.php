<?php

namespace Database\Seeders;

use App\Models\CargoType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CargoTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Furniture', 'description' => 'Home and office furniture'],
            ['name' => 'Electronics', 'description' => 'Electronic devices and appliances'],
            ['name' => 'Food & Beverages', 'description' => 'Food products and drinks'],
            ['name' => 'Building Materials', 'description' => 'Construction and building supplies'],
            ['name' => 'Household Items', 'description' => 'General household goods'],
            ['name' => 'Documents & Parcels', 'description' => 'Documents and small packages'],
            ['name' => 'Machinery', 'description' => 'Industrial and commercial machinery'],
            ['name' => 'Other', 'description' => 'Miscellaneous cargo types'],
        ];

        foreach ($types as $type) {
            CargoType::create([
                'name' => $type['name'],
                'slug' => Str::slug($type['name']),
                'description' => $type['description'],
                'is_active' => true,
            ]);
        }
    }
}
