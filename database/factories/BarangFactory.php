<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_barang' => $this->faker->words(2, true), // contoh: "Laptop Asus"
            'jumlah' => $this->faker->numberBetween(1, 100),
            'keterangan' => $this->faker->sentence(), // contoh: "Barang masih baru"
        ];
    }
}
