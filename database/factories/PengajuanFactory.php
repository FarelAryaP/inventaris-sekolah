<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Barang;
use App\Models\Admin;
use App\Models\Pengajuan;
use Carbon\Carbon;

class PengajuanFactory extends Factory
{
    protected $model = Pengajuan::class;

    public function definition(): array
    {
        $tglPengajuan = Carbon::now()->subDays(rand(1, 5));
        $tglMulai = (clone $tglPengajuan)->addDay();
        $tglSelesai = (clone $tglMulai)->addDay();

        return [
            'nisn' => User::inRandomOrder()->value('nisn'),
            'id_barang' => Barang::inRandomOrder()->value('id_barang'),
            'jumlah' => $this->faker->numberBetween(1, 5),
            'tgl_pengajuan' => $tglPengajuan,
            'tgl_mulai' => $tglMulai,
            'tgl_selesai' => $tglSelesai,
            'status' => 0, //pending
            'id_admin' => Admin::inRandomOrder()->value('id_admin'),
        ];
    }
}