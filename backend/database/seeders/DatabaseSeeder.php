<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Members\Models\Member;
use App\Domains\Tenancy\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Step 1: Create Permissions from JSON domain files
        $this->createPermissionsFromDomains();

        // Step 2: Create Roles with Permissions
        $roles = $this->createRoles();

        // Step 3: Create Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@membi.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create Test Organizations
        $organisations = [];

        $organisations[] = Organisation::create([
            'name' => 'Acme Sports Club',
            'seo_name' => 'acme-sports',
            'email' => 'info@acmesports.com',
            'phone' => '+44 20 1234 5678',
            'website' => 'https://acmesports.com',
            'description' => 'Premier sports club offering multiple activities',
            'free_trail' => true,
            'free_trail_end_date' => now()->addDays(30),
            'billing_policy' => 'debit_order',
            'is_active' => true,
        ]);

        $organisations[] = Organisation::create([
            'name' => 'Green Valley Association',
            'seo_name' => 'green-valley',
            'email' => 'contact@greenvalley.org',
            'phone' => '+44 20 9876 5432',
            'website' => 'https://greenvalley.org',
            'description' => 'Community association for Green Valley residents',
            'free_trail' => false,
            'free_trail_end_date' => now()->subDays(10),
            'billing_policy' => 'invoice',
            'is_active' => true,
        ]);

        $organisations[] = Organisation::create([
            'name' => 'Tech Professionals Network',
            'seo_name' => 'tech-pros',
            'email' => 'hello@techpros.io',
            'phone' => '+44 20 5555 1234',
            'website' => 'https://techpros.io',
            'description' => 'Professional network for technology industry members',
            'free_trail' => true,
            'free_trail_end_date' => now()->addDays(14),
            'billing_policy' => 'wallet',
            'is_active' => true,
        ]);

        // Attach super admin to all organisations
        foreach ($organisations as $org) {
            $superAdmin->organisations()->attach($org->id, ['role' => 'super_admin']);
        }

        // Set first org as active for super admin
        $superAdmin->active_organisation_id = $organisations[0]->id;
        $superAdmin->save();

        // Create regular test users for each organization
        foreach ($organisations as $index => $org) {
            // Create org admin
            $admin = User::create([
                'name' => "Admin {$org->name}",
                'email' => "admin@" . $org->seo_name . ".com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'active_organisation_id' => $org->id,
            ]);
            $admin->organisations()->attach($org->id, ['role' => 'admin']);

            // Create regular user
            $user = User::create([
                'name' => "User {$org->name}",
                'email' => "user@" . $org->seo_name . ".com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'active_organisation_id' => $org->id,
            ]);
            $user->organisations()->attach($org->id, ['role' => 'member']);

            // Create 5 test members for each organisation
            for ($i = 1; $i <= 5; $i++) {
                Member::create([
                    'organisation_id' => $org->id,
                    'user_id' => $i === 1 ? $user->id : null, // Link first member to user
                    'title' => ['Mr', 'Mrs', 'Ms', 'Dr'][array_rand(['Mr', 'Mrs', 'Ms', 'Dr'])],
                    'first_name' => "Member{$i}",
                    'last_name' => "Test",
                    'email' => "member{$i}@{$org->seo_name}.com",
                    'mobile_phone' => "+44 7" . rand(100, 999) . " " . rand(100000, 999999),
                    'date_of_birth' => now()->subYears(rand(20, 60)),
                    'gender' => ['male', 'female'][array_rand(['male', 'female'])],
                    'member_number' => "MEM" . str_pad($index * 100 + $i, 6, '0', STR_PAD_LEFT),
                    'joined_at' => now()->subMonths(rand(1, 24)),
                    'is_active' => true,
                    'roles' => json_encode(['member']),
                    'last_login_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }

        $this->command->info('✓ Super Admin created: admin@membi.com / password');
        $this->command->info('✓ 3 Organizations created');
        $this->command->info('✓ 6 Test users created (2 per org)');
        $this->command->info('✓ 15 Test members created (5 per org)');
    }

    /**
     * Create permissions from domain JSON files
     */
    protected function createPermissionsFromDomains()
    {
        $domainsPath = base_path('domains');
        $jsonFiles = File::glob($domainsPath . '/*.json');

        $permissionCount = 0;
        $modules = [];

        foreach ($jsonFiles as $file) {
            $content = json_decode(File::get($file), true);

            if (!isset($content['domain']) || !isset($content['entities'])) {
                continue;
            }

            $domain = $content['domain'];
            $modules[$domain] = [];

            foreach ($content['entities'] as $entityName => $entityData) {
                // Only create permissions for aggregate roots (entities with full CRUD)
                $isAggregateRoot = $entityData['aggregate_root'] ?? false;

                if (!$isAggregateRoot) {
                    continue;
                }

                $entityLower = strtolower($entityName);
                $actions = ['view', 'create', 'update', 'delete'];

                foreach ($actions as $action) {
                    $permissionName = "{$entityLower}.{$action}";

                    Permission::create([
                        'name' => $permissionName,
                        'display_name' => ucfirst($action) . ' ' . $entityName,
                        'description' => "Permission to {$action} {$entityName} records",
                        'module' => $domain,
                    ]);

                    $modules[$domain][] = $permissionName;
                    $permissionCount++;
                }
            }
        }

        $this->command->info("✓ Created {$permissionCount} permissions from " . count($jsonFiles) . " domain files");

        return $modules;
    }

    /**
     * Create roles with appropriate permissions
     */
    protected function createRoles()
    {
        $allPermissions = Permission::all();

        // Super Admin Role (Global - all permissions)
        $superAdminRole = Role::create([
            'organisation_id' => null, // Global role
            'name' => 'super_admin',
            'display_name' => 'Super Administrator',
            'description' => 'Full system access with all permissions',
            'is_system' => true,
        ]);
        $superAdminRole->permissions()->attach($allPermissions->pluck('id'));

        // Organisation Admin Role (Global template)
        $adminRole = Role::create([
            'organisation_id' => null, // Global role
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Organisation administrator with full access to organisation data',
            'is_system' => true,
        ]);
        // Admin gets all permissions except system-level permissions
        $adminPermissions = $allPermissions->reject(function ($permission) {
            return in_array($permission->module, ['Auth']); // Exclude auth management
        });
        $adminRole->permissions()->attach($adminPermissions->pluck('id'));

        // Member Role (Global template)
        $memberRole = Role::create([
            'organisation_id' => null, // Global role
            'name' => 'member',
            'display_name' => 'Member',
            'description' => 'Basic member with view-only access',
            'is_system' => true,
        ]);
        // Members only get view permissions
        $memberPermissions = $allPermissions->filter(function ($permission) {
            return str_contains($permission->name, '.view');
        });
        $memberRole->permissions()->attach($memberPermissions->pluck('id'));

        // Read-Only Role (Global template)
        $readOnlyRole = Role::create([
            'organisation_id' => null, // Global role
            'name' => 'read_only',
            'display_name' => 'Read Only',
            'description' => 'View-only access to all organisation data',
            'is_system' => true,
        ]);
        $readOnlyRole->permissions()->attach($memberPermissions->pluck('id'));

        $this->command->info('✓ Created 4 system roles with permissions');

        return [
            'super_admin' => $superAdminRole,
            'admin' => $adminRole,
            'member' => $memberRole,
            'read_only' => $readOnlyRole,
        ];
    }
}
