<?php

namespace Database\Seeders;

use App\Models\Penerbit;
use Illuminate\Database\Seeder;

class PenerbitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Penerbit::create([
            'kode' => 'bp',
            'nama' => 'Balai Pustaka.'
        ]);
        
        Penerbit::create([
            'kode' => 'eb',
            'nama' => 'Encyclopædia Britannica'
        ]);
    }
}
