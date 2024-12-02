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
        Schema::create('asets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_barang')->nullable();
            $table->foreignId('id_master_jenis')->nullable()->constrained('jenis')->onDelete('cascade');
            $table->string('nomor_aset')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('part_number')->nullable();
            $table->text('spek')->nullable();
            $table->string('pengguna')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('foto_aset')->nullable();
            $table->year('tahun_kepemilikan')->nullable();
            $table->enum('status', ['rusak', 'kurang_layak', 'baik'])->nullable();
            $table->foreignId('id_kepemilikan')->nullable()->constrained('kepemilikans')->onDelete('cascade');
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
        Schema::dropIfExists('asets');
    }
};
