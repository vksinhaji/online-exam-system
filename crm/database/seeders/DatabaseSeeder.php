<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\DocumentRequirement;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);

        // create admin
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => 'password',
        ]);
        $admin->assignRole($adminRole);

        // create a couple of staff
        foreach ([
            ['name' => 'Staff One', 'email' => 'staff1@example.com'],
            ['name' => 'Staff Two', 'email' => 'staff2@example.com'],
        ] as $userData) {
            $user = User::firstOrCreate([
                'email' => $userData['email'],
            ], [
                'name' => $userData['name'],
                'password' => 'password',
            ]);
            $user->assignRole($staffRole);
        }

        // seed some services and documents
        $services = [
            [
                'name' => 'PAN Application',
                'description' => 'New or correction of PAN card',
                'expected_completion_days' => 5,
                'documents' => [
                    ['name' => 'Aadhaar Card', 'is_mandatory' => true],
                    ['name' => 'Passport photo', 'is_mandatory' => true],
                    ['name' => 'Address proof', 'is_mandatory' => false],
                ],
            ],
            [
                'name' => 'Aadhaar Update',
                'description' => 'Update Aadhaar details',
                'expected_completion_days' => 3,
                'documents' => [
                    ['name' => 'Existing Aadhaar', 'is_mandatory' => true],
                    ['name' => 'Support document', 'is_mandatory' => true],
                ],
            ],
        ];

        foreach ($services as $serviceData) {
            $docs = $serviceData['documents'];
            unset($serviceData['documents']);
            $service = Service::firstOrCreate(
                ['name' => $serviceData['name']],
                $serviceData
            );
            foreach ($docs as $doc) {
                DocumentRequirement::firstOrCreate([
                    'service_id' => $service->id,
                    'name' => $doc['name'],
                ], [
                    'is_mandatory' => $doc['is_mandatory'],
                ]);
            }
        }
    }
}
