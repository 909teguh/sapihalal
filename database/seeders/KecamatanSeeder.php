<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $data = [
            ['code' => '13.71.01', 'name' => 'Padang Selatan'],
            ['code' => '13.71.02', 'name' => 'Padang Timur'],
            ['code' => '13.71.03', 'name' => 'Padang Barat'],
            ['code' => '13.71.04', 'name' => 'Padang Utara'],
            ['code' => '13.71.05', 'name' => 'Bungus Teluk Kabung'],
            ['code' => '13.71.06', 'name' => 'Lubuk Begalung'],
            ['code' => '13.71.07', 'name' => 'Lubuk Kilangan'],
            ['code' => '13.71.08', 'name' => 'Pauh'],
            ['code' => '13.71.09', 'name' => 'Kuranji'],
            ['code' => '13.71.10', 'name' => 'Nanggalo'],
            ['code' => '13.71.11', 'name' => 'Koto Tangah'],
        ];

        // Tambahkan timestamp otomatis ke setiap array
        $kecamatan = array_map(function ($item) use ($now) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
            return $item;
        }, $data);

        DB::table('kecamatan')->insert($kecamatan);
    }
}