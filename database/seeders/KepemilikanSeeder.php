<?php

namespace Database\Seeders;

use App\Models\Kepemilikan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KepemilikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kepemilikans = [
            ['kepemilikan' => 'Internal'],
            ['kepemilikan' => 'Pihak Ketiga'],
        ];

        foreach ($kepemilikans as $kepemilikan) {
            Kepemilikan::create([
                'kepemilikan' => $kepemilikan['kepemilikan'],
            ]);
        }
    }
}
