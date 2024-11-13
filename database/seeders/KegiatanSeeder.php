<?php

namespace Database\Seeders;

use App\Models\MasterKegiatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opsiKegiatan = [
            ['kegiatan' => 'Pemeliharaan Rutin', 'is_custom' => false],
            ['kegiatan' => 'Perbaikan', 'is_custom' => false],
            ['kegiatan' => 'Penggantian Komponen', 'is_custom' => false],
            ['kegiatan' => 'Inspeksi', 'is_custom' => false],
            ['kegiatan' => 'Kalibrasi', 'is_custom' => false],
            ['kegiatan' => 'Lainnya', 'is_custom' => true], // Opsi untuk input bebas
        ];

        foreach ($opsiKegiatan as $opsi) {
            MasterKegiatan::create($opsi);
        }
    }
}
