<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('nomorWa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_pegawai');
    }
};
