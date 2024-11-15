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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_aset')->constrained('asets')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_master_kegiatan')->constrained('master_kegiatans');
            $table->string('custom_kegiatan')->nullable(); // Untuk input bebas ketika memilih "Lainnya"
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->index('created_at');
            $table->index(['id_aset', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
