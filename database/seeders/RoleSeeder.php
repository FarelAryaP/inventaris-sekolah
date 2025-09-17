<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use GuzzleHttp\Promise\Create;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'nama' => 'Super Admin', 
            'deskripsi' => 'Admin dengan akses penuh' 

        ]);
        
        Role::create([
            'nama' => 'Admin', 
            'deskripsi' => 'Admin biasa' 

        ]);


    }
}
