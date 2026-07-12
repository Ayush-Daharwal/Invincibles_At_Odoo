<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Fleetbase\Models\Policy;
use Fleetbase\Models\Role;
use Fleetbase\Models\Permission;
use Illuminate\Support\Str;

class TransitOpsRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guard = 'sanctum';
        $service = 'fleet-ops';

        $permissionsToEnsure = [
            '* vehicle', '* driver', '* fleet', '* maintenance', '* work-order', '* equipment', '* part', '* report', '* activity',
            '* order', '* route', '* service-rate', '* service-area', '* zone', 'see vehicle', 'list vehicle', 'view vehicle',
            'see driver', 'list driver', 'view driver', 'see order', 'list order', 'view order', '* fuel-report', '* issue', 'see extension'
        ];

        foreach ($permissionsToEnsure as $permName) {
            $fullPermName = Str::startsWith($permName, $service) ? $permName : $service . ' ' . $permName;
            Permission::firstOrCreate(
                ['name' => $fullPermName, 'guard_name' => $guard],
                ['service' => $service]
            );
        }

        // 1. Fleet Manager
        $fmPolicy = Policy::updateOrCreate(
            ['name' => 'TransitOpsFleetManager', 'guard_name' => $guard],
            ['description' => 'Policy for Fleet Manager.', 'service' => $service]
        );
        $fmPerms = ['see extension', '* vehicle', '* driver', '* fleet', '* maintenance', '* work-order', '* equipment', '* part', '* report', '* activity'];
        foreach ($fmPerms as $perm) {
            $fullPerm = Str::startsWith($perm, $service) ? $perm : $service . ' ' . $perm;
            $fmPolicy->givePermissionTo(Permission::findByName($fullPerm, $guard));
        }
        $fmRole = Role::updateOrCreate(
            ['name' => 'Fleet Manager', 'guard_name' => $guard],
            ['description' => 'Owns vehicles and their maintenance lifecycle', 'service' => $service]
        );
        $fmRole->assignPolicy($fmPolicy);

        // 2. Dispatcher
        $dispatcherPolicy = Policy::updateOrCreate(
            ['name' => 'TransitOpsDispatcher', 'guard_name' => $guard],
            ['description' => 'Policy for Dispatcher.', 'service' => $service]
        );
        $dispatcherPerms = ['see extension', '* order', '* route', '* service-rate', '* service-area', '* zone', 'see vehicle', 'list vehicle', 'view vehicle', 'see driver', 'list driver', 'view driver'];
        foreach ($dispatcherPerms as $perm) {
            $fullPerm = Str::startsWith($perm, $service) ? $perm : $service . ' ' . $perm;
            $dispatcherPolicy->givePermissionTo(Permission::findByName($fullPerm, $guard));
        }
        $dispatcherRole = Role::updateOrCreate(
            ['name' => 'Dispatcher', 'guard_name' => $guard],
            ['description' => 'Owns trip creation and the live operations board', 'service' => $service]
        );
        $dispatcherRole->assignPolicy($dispatcherPolicy);

        // 3. Safety Officer
        $soPolicy = Policy::updateOrCreate(
            ['name' => 'TransitOpsSafetyOfficer', 'guard_name' => $guard],
            ['description' => 'Policy for Safety Officer.', 'service' => $service]
        );
        $soPerms = ['see extension', '* driver', 'see order', 'list order', 'view order'];
        foreach ($soPerms as $perm) {
            $fullPerm = Str::startsWith($perm, $service) ? $perm : $service . ' ' . $perm;
            $soPolicy->givePermissionTo(Permission::findByName($fullPerm, $guard));
        }
        $soRole = Role::updateOrCreate(
            ['name' => 'Safety Officer', 'guard_name' => $guard],
            ['description' => 'Owns driver records, licensing, and compliance', 'service' => $service]
        );
        $soRole->assignPolicy($soPolicy);

        // 4. Financial Analyst
        $faPolicy = Policy::updateOrCreate(
            ['name' => 'TransitOpsFinancialAnalyst', 'guard_name' => $guard],
            ['description' => 'Policy for Financial Analyst.', 'service' => $service]
        );
        $faPerms = ['see extension', '* fuel-report', '* report', '* issue', 'see vehicle', 'list vehicle', 'view vehicle', 'see order', 'list order', 'view order'];
        foreach ($faPerms as $perm) {
            $fullPerm = Str::startsWith($perm, $service) ? $perm : $service . ' ' . $perm;
            $faPolicy->givePermissionTo(Permission::findByName($fullPerm, $guard));
        }
        $faRole = Role::updateOrCreate(
            ['name' => 'Financial Analyst', 'guard_name' => $guard],
            ['description' => 'Owns fuel/expense tracking and reporting', 'service' => $service]
        );
        $faRole->assignPolicy($faPolicy);
    }
}
