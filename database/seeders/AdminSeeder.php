<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'superAdmin',
            'nama' => 'Administrator',
            'password' => 'admin123', // Will be hashed by model
            'id_role' => 1
        ]);

        Admin::create([
            'username' => 'staff',
            'nama' => 'Staff Inventaris',
            'password' => 'staff123',
            'id_role' => 2
        ]);
    }
}

