<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@portal.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'status' => 'offline',
                'region' => null,
            ],
            [
                'name' => 'John Sales',
                'email' => 'sales@portal.com',
                'password' => Hash::make('password'),
                'role' => 'sales',
                'status' => 'offline',
                'region' => null,
            ],
            [
                'name' => 'Jane Onboarding',
                'email' => 'onboarding@portal.com',
                'password' => Hash::make('password'),
                'role' => 'onboarding',
                'status' => 'offline',
                'region' => null,
            ],
            [
                'name' => 'Mike VA',
                'email' => 'va@portal.com',
                'password' => Hash::make('password'),
                'role' => 'va',
                'status' => 'offline',
                'region' => null,
            ],
            [
                'name' => 'US Accountant',
                'email' => 'accounts_us@portal.com',
                'password' => Hash::make('password'),
                'role' => 'accounts',
                'status' => 'offline',
                'region' => 'USA',
            ],
            [
                'name' => 'PK Accountant',
                'email' => 'accounts_pk@portal.com',
                'password' => Hash::make('password'),
                'role' => 'accounts',
                'status' => 'offline',
                'region' => 'Pakistan',
            ],
            [
                'name' => 'Sarah HR',
                'email' => 'hr@portal.com',
                'password' => Hash::make('password'),
                'role' => 'hr',
                'status' => 'offline',
                'region' => null,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
