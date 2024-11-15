<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenis = [
            ['jenis' => 'Printer'],
            ['jenis' => 'PC'],
            ['jenis' => 'Laptop'],
            ['jenis' => 'HP'],
            ['jenis' => 'AC'],
            ['jenis' => 'Audio'],
            ['jenis' => 'Kipas Angin'],
        ];

        foreach ($jenis as $j)
        {
            Jenis::create([
                'jenis' => $j['jenis']
            ]);
        }
    }
}
