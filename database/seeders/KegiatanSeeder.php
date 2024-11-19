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
            ['kegiatan' => 'Pemeliharaan Rutin'],
            ['kegiatan' => 'Perbaikan'],
            ['kegiatan' => 'Penggantian Komponen'],
            ['kegiatan' => 'Inspeksi'],
            ['kegiatan' => 'Kalibrasi'],
            ['kegiatan' => 'Pengisian Tinta'],
            ['kegiatan' => 'Lainnya'],
        ];

        foreach ($opsiKegiatan as $opsi) {
            MasterKegiatan::create($opsi);
        }
    }
}
