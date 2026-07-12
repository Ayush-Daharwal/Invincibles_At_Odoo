<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Fleetbase\Models\User;
use Fleetbase\Models\Company;
use Fleetbase\Models\Role;
use Illuminate\Support\Facades\Hash;

class TransitOpsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find a default company to attach the users to
        $company = Company::first();
        $companyId = $company ? $company->uuid : null;

        $users = [
            [
                'name' => 'Fleet Manager User',
                'email' => 'fleetmanager@transitops.com',
                'role' => 'Fleet Manager',
            ],
            [
                'name' => 'Dispatcher User',
                'email' => 'dispatcher@transitops.com',
                'role' => 'Dispatcher',
            ],
            [
                'name' => 'Safety Officer User',
                'email' => 'safetyofficer@transitops.com',
                'role' => 'Safety Officer',
            ],
            [
                'name' => 'Financial Analyst User',
                'email' => 'financialanalyst@transitops.com',
                'role' => 'Financial Analyst',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'company_uuid' => $companyId,
                    'phone' => '1234567890'
                ]
            );

            // Assign the role
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->assignRole($role);
            }
        }
    }
}
