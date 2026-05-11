<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("
            INSERT INTO companies (name, slug, created_at, updated_at)
            VALUES ('jaynik Eduserve pvt. ltd.', 'jaynik-edu', NOW(), NOW())
        ");
    }
}
