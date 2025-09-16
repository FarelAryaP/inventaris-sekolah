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
            'username' => 'super admin',
            'nama' => 'Administrator',
            'password' => 'admin123', // Will be hashed by model
            'id_role' => 1
        ]);

        Admin::create([
            'username' => 'staff1',
            'nama' => 'Staff Inventaris 1',
            'password' => 'staff123',
            'id_role' => 2
        ]);
        
        Admin::create([
            'username' => 'staff2',
            'nama' => 'Staff Inventaris 2',
            'password' => 'staff123',
            'id_role' => 2
        ]);
    }
}

