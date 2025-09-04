<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id('id_pengajuan');
            $table->unsignedBigInteger('nisn');
            $table->unsignedBigInteger('id_barang');
            $table->integer('jumlah')->default(0);
            $table->dateTime('tgl_pengajuan');
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->tinyInteger('status')->comment('0 = pending, 1 = approved, 2 = rejected');
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nisn')->references('nisn')->on('user');
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreign('id_admin')->references('id_admin')->on('admin');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
