<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Small Van', 'description' => 'Compact van suitable for small loads'],
            ['name' => 'Large Van', 'description' => 'Spacious van for medium to large cargo'],
            ['name' => 'Pickup Truck', 'description' => 'Open bed truck for various cargo types'],
            ['name' => 'Box Truck', 'description' => 'Enclosed truck for weather-protected transport'],
            ['name' => 'Flatbed Truck', 'description' => 'Open flatbed for oversized items'],
            ['name' => 'Refrigerated Truck', 'description' => 'Temperature-controlled for perishables'],
        ];

        foreach ($types as $type) {
            VehicleType::create([
                'name' => $type['name'],
                'slug' => Str::slug($type['name']),
                'description' => $type['description'],
                'is_active' => true,
            ]);
        }
    }
}
