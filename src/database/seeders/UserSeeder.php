<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder class for generating 15 system operator accounts.
 * Fulfills Requirement A testing with diverse operator credentials.
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $password = Hash::make('password123');

        $users = [
            ['name' => 'Main Gate Operator',    'email' => 'operator@gateops.com'],
            ['name' => 'Admin',    'email' => 'admin@gmail.com'],
            ['name' => 'Security Team Lead',   'email' => 'security@gateops.com'],
            ['name' => 'Alex Kibet',            'email' => 'alex.kibet@gateops.com'],
            ['name' => 'Brenda Wanjiru',       'email' => 'brenda.wanjiru@gateops.com'],
            ['name' => 'Charles Otieno',        'email' => 'charles.otieno@gateops.com'],
            ['name' => 'Dennis Mutua',         'email' => 'dennis.mutua@gateops.com'],
            ['name' => 'Eunice Njeri',         'email' => 'eunice.njeri@gateops.com'],
            ['name' => 'Francis Korir',        'email' => 'francis.korir@gateops.com'],
            ['name' => 'Grace Achieng',        'email' => 'grace.achieng@gateops.com'],
            ['name' => 'Hassan Mohamed',       'email' => 'hassan.mohamed@gateops.com'],
            ['name' => 'Irene Kiprop',         'email' => 'irene.kiprop@gateops.com'],
            ['name' => 'Joseph Omwamba',       'email' => 'joseph.omwamba@gateops.com'],
            ['name' => 'Karen Mwangi',         'email' => 'karen.mwangi@gateops.com'],
            ['name' => 'Leonard Ndung\'u',     'email' => 'leonard.ndungu@gateops.com'],
            ['name' => 'Mary Chemutai',        'email' => 'mary.chemutai@gateops.com'],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'name'     => $user['name'],
                    'password' => $password,
                ]
            );
        }
    }
}