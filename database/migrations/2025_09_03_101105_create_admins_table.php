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
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('username', 100)->unique();
            $table->string('nama', 100);
            $table->string('password', 100);
            $table->unsignedBigInteger('id_role');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_role')->references('id_role')->on('role');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
