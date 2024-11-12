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
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_barang')->nullable();
            $table->string('jenis')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('part_number')->nullable();
            $table->text('spek')->nullable();
            $table->year('tahun_kepemilikan')->nullable();
            $table->foreignId('id_kepemilikan')->constrained('kepemilikans')->onDelete('cascade');
            $table->timestamps();

            $table->index('created_at');
            $table->index(['id_kepemilikan', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
