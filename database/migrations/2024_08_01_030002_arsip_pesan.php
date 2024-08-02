<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip_pesan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nip');
            $table->string('nama');
            $table->string('nomorWa');
            $table->string('pesan');
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip_pesan');
    }
};
