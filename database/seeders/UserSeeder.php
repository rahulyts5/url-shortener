<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
    {
        // Get the company we just created
        $company = DB::table('companies')->where('slug', 'jaynik-edu')->first();

        // SuperAdmin
        DB::statement("
            INSERT INTO users (name, email, password, role, company_id, created_at, updated_at)
            VALUES (
                'Super Admin',
                'superadmin@example.com',
                '" . Hash::make('password') . "',
                'superadmin',
                {$company->id},
                NOW(),
                NOW()
            )
        ");

        // Admin
        DB::statement("
            INSERT INTO users (name, email, password, role, company_id, created_at, updated_at)
            VALUES (
                'Admin User',
                'admin@example.com',
                '" . Hash::make('password') . "',
                'admin',
                {$company->id},
                NOW(),
                NOW()
            )
        ");

        // Member
        DB::statement("
            INSERT INTO users (name, email, password, role, company_id, created_at, updated_at)
            VALUES (
                'Member User',
                'member@example.com',
                '" . Hash::make('password') . "',
                'member',
                {$company->id},
                NOW(),
                NOW()
            )
        ");

    }
}
