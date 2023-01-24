<?php

namespace Database\Seeders;

use App\Models\Identitas;
use Illuminate\Database\Seeder;

class IdentitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Identitas::create([
            'nama_app' => 'Learn LSP Perpus',
            'photo' => '',
            'alamat_app' => 'Jl. SMEA 6',
            'email_app' => 'smea6@gmail.com',
            'nomor_hp' => '098012313'
        ]);
    }
}
