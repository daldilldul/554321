<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'han',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => '12345'
            ],
            // [
            //     'name' => 'dli',
            //     'email' => 'bank@gmail.com',
            //     'role' => 'bank',
            //     'password' => '12345'
            // ],[
            //     'name' => 'jul',
            //     'email' => 'siswa@gmail.com',
            //     'role' => 'siswa',
            //     'password' => '12345'
            // ],
        ];

        foreach($userData as $item) {
            User::create($item);
            Hash::make('password');
        }
    }
}
