<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

/**
 * Seeder class for generating 15 vehicle registration entries.
 * Populates diverse fleet plates for selection testing during gate operations.
 */
class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $vehicles = [
            ['registration_number' => 'KDA 101A', 'vehicle_type' => 'Isuzu Truck'],
            ['registration_number' => 'KDB 202B', 'vehicle_type' => 'Toyota Hilux Pickup'],
            ['registration_number' => 'KDC 303C', 'vehicle_type' => 'Mitsubishi Canter'],
            ['registration_number' => 'KDD 404D', 'vehicle_type' => 'Nissan Diesel Trailer'],
            ['registration_number' => 'KDE 505E', 'vehicle_type' => 'Mercedes Actros Heavy Truck'],
            ['registration_number' => 'KDF 606F', 'vehicle_type' => 'Scania Hauler'],
            ['registration_number' => 'KDG 707G', 'vehicle_type' => 'FAW Tipper Truck'],
            ['registration_number' => 'KDH 808H', 'vehicle_type' => 'Hino Cargo Van'],
            ['registration_number' => 'KDJ 909J', 'vehicle_type' => 'Tata Prima Truck'],
            ['registration_number' => 'KDK 010K', 'vehicle_type' => 'Howo Dump Truck'],
            ['registration_number' => 'KDL 111L', 'vehicle_type' => 'Toyota HiAce Support Van'],
            ['registration_number' => 'KDM 222M', 'vehicle_type' => 'Isuzu FRR Box Body'],
            ['registration_number' => 'KDN 333N', 'vehicle_type' => 'Volvo FH16 Tractor'],
            ['registration_number' => 'KDP 444P', 'vehicle_type' => 'UD Trucks Prime Mover'],
            ['registration_number' => 'KDQ 555Q', 'vehicle_type' => 'Mitsubishi Fuso Fighter'],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::firstOrCreate(
                ['registration_number' => $vehicle['registration_number']],
                $vehicle
            );
        }
    }
}