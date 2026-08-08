<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

/**
 * Seeder class for populating 15 driver profiles.
 * Provides complete driver profiles for Gate In auto-population and search workflows.
 */
class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $drivers = [
            ['name' => 'John Doe',         'driver_id' => 'DL-987654321', 'phone_number' => '+254711000111'],
            ['name' => 'Jane Smith',        'driver_id' => 'DL-123456789', 'phone_number' => '+254722000222'],
            ['name' => 'Michael Johnson',  'driver_id' => 'DL-456789123', 'phone_number' => '+254733000333'],
            ['name' => 'Sarah Connor',     'driver_id' => 'DL-789123456', 'phone_number' => '+254744000444'],
            ['name' => 'Peter Omondi',     'driver_id' => 'DL-112233445', 'phone_number' => '+254755000555'],
            ['name' => 'Lucy Wambui',      'driver_id' => 'DL-223344556', 'phone_number' => '+254766000666'],
            ['name' => 'David Maina',      'driver_id' => 'DL-334455667', 'phone_number' => '+254777000777'],
            ['name' => 'Esther Nafula',    'driver_id' => 'DL-445566778', 'phone_number' => '+254788000888'],
            ['name' => 'Samuel Kamau',     'driver_id' => 'DL-556677889', 'phone_number' => '+254799000999'],
            ['name' => 'Ruth Adhiambo',    'driver_id' => 'DL-667788990', 'phone_number' => '+254712345678'],
            ['name' => 'Benson Cheruiyot', 'driver_id' => 'DL-778899001', 'phone_number' => '+254723456789'],
            ['name' => 'Catherine Muthoni','driver_id' => 'DL-889900112', 'phone_number' => '+254734567890'],
            ['name' => 'Gideon Kiprono',   'driver_id' => 'DL-990011223', 'phone_number' => '+254745678901'],
            ['name' => 'Hannah Nyambura',  'driver_id' => 'DL-101112131', 'phone_number' => '+254756789012'],
            ['name' => 'Isaac Wafula',     'driver_id' => 'DL-141516171', 'phone_number' => '+254767890123'],
        ];

        foreach ($drivers as $driver) {
            Driver::firstOrCreate(
                ['driver_id' => $driver['driver_id']],
                $driver
            );
        }
    }
}