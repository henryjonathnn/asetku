<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Ganang', 'username' => 'ganang', 'password' => 'password123'],
            ['name' => 'Adika Wicaksana', 'username' => 'adika_wicaksana', 'password' => 'password123'],
            ['name' => 'Agus', 'username' => 'agus', 'password' => 'password123'],
            ['name' => 'Ali Muhson', 'username' => 'ali_muhson', 'password' => 'password123'],
            ['name' => 'Bayu', 'username' => 'bayu', 'password' => 'password123'],
            ['name' => 'Pebri', 'username' => 'pebri', 'password' => 'password123'],
            ['name' => 'Virgie', 'username' => 'virgie', 'password' => 'password123'],
        ];
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'password' => Hash::make($user['password']), // Hash password for security
            ]);
        }
    }
}
