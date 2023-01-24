<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'kode' => '123123',
            'nis' => '123123',
            'fullname' => 'Fernando',
            'username' => 'Frer',
            'password' => Hash::make('password'),
            'kelas' => '12 RPL',
            'alamat' => '',
            'photo' => '',
            'verif' => 'verified',
            'role' => 'user',
            'join_date' => '2023-01-06'
        ]);

        User::create([
            'kode' => '1231233',
            'nis' => '',
            'fullname' => 'Fernando1',
            'username' => 'Fer',
            'password' => Hash::make('password'),
            'kelas' => '',
            'alamat' => '',
            'photo' => '',
            'verif' => 'verified',
            'role' => 'admin',
            'join_date' => '2023-01-06'
        ]);
    }
}
