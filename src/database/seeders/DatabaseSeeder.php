<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Main Database Seeder orchestrator.
 * Executes seeders in order: Users -> Drivers -> Vehicles.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        /*
         * Execute required domain seeders in sequence
         * to populate foundational system records.
         */
        $this->call([
            UserSeeder::class,
            DriverSeeder::class,
            VehicleSeeder::class,
        ]);
    }
}