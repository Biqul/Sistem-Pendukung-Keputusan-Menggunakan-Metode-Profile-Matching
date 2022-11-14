<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembukaan_seleksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class PembukaanSeleksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pembukaan_seleksi::factory(10)->create();
    }
}
