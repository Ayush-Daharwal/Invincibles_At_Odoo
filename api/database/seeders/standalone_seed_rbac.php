<?php

require __DIR__.'/../../vendor/autoload.php';
$app = require_once __DIR__.'/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Fleetbase\Models\Policy;
use Fleetbase\Models\Role;
use Fleetbase\Models\Permission;
use Fleetbase\Models\User;
use Fleetbase\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

$guard = 'sanctum';
$service = 'fleet-ops';

function ensurePermission($name, $service, $guard) {
    return Permission::firstOrCreate(
        ['name' => $name, 'guard_name' => $guard],
        ['service' => $service]
    );
}

// 1. Create permissions
$permissionsToEnsure = [
    '* vehicle', '* driver', '* fleet', '* maintenance', '* work-order', '* equipment', '* part', '* report', '* activity',
    '* order', '* route', '* service-rate', '* service-area', '* zone', 'see vehicle', 'list vehicle', 'view vehicle',
    'see driver', 'list driver', 'view driver', 'see order', 'list order', 'view order', '* fuel-report', '* issue', 'see extension'
];

foreach ($permissionsToEnsure as $permName) {
    $fullPermName = Str::startsWith($permName, $service) ? $permName : $service . ' ' . $permName;
    ensurePermission($fullPermName, $service, $guard);
}

// 2. Roles and Policies
$rolesData = [
    [
        'role' => 'Fleet Manager',
        'policy' => 'TransitOpsFleetManager',
        'description' => 'Owns vehicles and their maintenance lifecycle',
        'perms' => ['see extension', '* vehicle', '* driver', '* fleet', '* maintenance', '* work-order', '* equipment', '* part', '* report', '* activity']
    ],
    [
        'role' => 'Dispatcher',
        'policy' => 'TransitOpsDispatcher',
        'description' => 'Owns trip creation and the live operations board',
        'perms' => ['see extension', '* order', '* route', '* service-rate', '* service-area', '* zone', 'see vehicle', 'list vehicle', 'view vehicle', 'see driver', 'list driver', 'view driver']
    ],
    [
        'role' => 'Safety Officer',
        'policy' => 'TransitOpsSafetyOfficer',
        'description' => 'Owns driver records, licensing, and compliance',
        'perms' => ['see extension', '* driver', 'see order', 'list order', 'view order']
    ],
    [
        'role' => 'Financial Analyst',
        'policy' => 'TransitOpsFinancialAnalyst',
        'description' => 'Owns fuel/expense tracking and reporting',
        'perms' => ['see extension', '* fuel-report', '* report', '* issue', 'see vehicle', 'list vehicle', 'view vehicle', 'see order', 'list order', 'view order']
    ]
];

foreach ($rolesData as $rd) {
    $policy = Policy::updateOrCreate(
        ['name' => $rd['policy'], 'guard_name' => $guard],
        ['description' => 'Policy for '.$rd['role'], 'service' => $service]
    );
    foreach ($rd['perms'] as $perm) {
        $fullPerm = Str::startsWith($perm, $service) ? $perm : $service . ' ' . $perm;
        $policy->givePermissionTo(Permission::findByName($fullPerm, $guard));
    }
    $role = Role::updateOrCreate(
        ['name' => $rd['role'], 'guard_name' => $guard],
        ['description' => $rd['description'], 'service' => $service]
    );
    $role->assignPolicy($policy);
}

// 3. Create Users
$company = Company::first();
if (!$company) {
    echo "No company found. Creating a default company for TransitOps...\n";
    $company = Company::create(['name' => 'TransitOps Corporation']);
}
$companyId = $company->uuid;

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
    $user = User::where('email', $userData['email'])->first();
    if (!$user) {
        $user = new User([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'phone' => '123456789' . rand(0, 9),
            'type' => 'user',
            'status' => 'active'
        ]);
        $user->password = Hash::make('password');
        $user->company_uuid = $companyId;
        $user->save();
    }
    
    $user->assignCompany($company, $userData['role']);
}

echo "Roles, Policies, and Test Users successfully created!\n";
