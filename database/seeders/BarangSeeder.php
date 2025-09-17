<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barang::factory()->count(5)->create();

        Barang::create([
            'nama_barang' => 'low quantity item',
            'jumlah' => 2,
            'keterangan' => 'test',
        ]);
    }
}
