<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelurahanSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        
        $data = [
            // Padang Selatan (13.71.01)
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1001', 'name' => 'Belakang Pondok'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1002', 'name' => 'Alang Laweh'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1003', 'name' => 'Ranah Parak Rumbio'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1004', 'name' => 'Pasa Gadang'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1005', 'name' => 'Batang Arau'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1006', 'name' => 'Seberang Palinggam'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1007', 'name' => 'Seberang Padang'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1008', 'name' => 'Mata Air'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1009', 'name' => 'Rawang'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1010', 'name' => 'Teluk Bayur'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1011', 'name' => 'Air Manis'],
            ['kecamatan_code' => '13.71.01', 'code' => '13.71.01.1012', 'name' => 'Bukit Gado-gado'],

            // Padang Timur (13.71.02)
            ['kecamatan_code' => '13.71.02', 'code' => '13.71.02.1001', 'name' => 'Sawahan'],
            ['kecamatan_code' => '13.71.02', 'code' => '13.71.02.1002', 'name' => 'Jati Baru'],
            ['kecamatan_code' => '13.71.02', 'code' => '13.71.02.1003', 'name' => 'Jati'],
            ['kecamatan_code' => '13.71.02', 'code' => '13.71.02.1004', 'name' => 'Sawahan Timur'],
            ['kecamatan_code' => '13.71.02', 'code' => '13.71.02.1005', 'name' => 'Simpang Haru'],
            ['kecamatan_code' => '13.71.02', 'code' => '13.71.02.1006', 'name' => 'Kubu Marapalam'],
            ['kecamatan_code' => '13.71.02', 'code' => '13.71.02.1007', 'name' => 'Andalas'],
            ['kecamatan_code' => '13.71.02', 'code' => '13.71.02.1008', 'name' => 'Kubu Dalam Parak Karakah'],
            ['kecamatan_code' => '13.71.02', 'code' => '13.71.02.1009', 'name' => 'Parak Gadang Timur'],
            ['kecamatan_code' => '13.71.02', 'code' => '13.71.02.1010', 'name' => 'Ganting Parak Gadang'],

            // Padang Barat (13.71.03)
            ['kecamatan_code' => '13.71.03', 'code' => '13.71.03.1001', 'name' => 'Flamboyan Baru'],
            ['kecamatan_code' => '13.71.03', 'code' => '13.71.03.1002', 'name' => 'Rimbo Kaluang'],
            ['kecamatan_code' => '13.71.03', 'code' => '13.71.03.1003', 'name' => 'Ujung Gurun'],
            ['kecamatan_code' => '13.71.03', 'code' => '13.71.03.1004', 'name' => 'Purus'],
            ['kecamatan_code' => '13.71.03', 'code' => '13.71.03.1005', 'name' => 'Padang Pasir'],
            ['kecamatan_code' => '13.71.03', 'code' => '13.71.03.1006', 'name' => 'Olo'],
            ['kecamatan_code' => '13.71.03', 'code' => '13.71.03.1007', 'name' => 'Kampung Jawa'],
            ['kecamatan_code' => '13.71.03', 'code' => '13.71.03.1008', 'name' => 'Belakang Tangsi'],
            ['kecamatan_code' => '13.71.03', 'code' => '13.71.03.1009', 'name' => 'Kampung Pondok'],
            ['kecamatan_code' => '13.71.03', 'code' => '13.71.03.1010', 'name' => 'Berok Nipah'],

            // Padang Utara (13.71.04)
            ['kecamatan_code' => '13.71.04', 'code' => '13.71.04.1001', 'name' => 'Air Tawar Timur'],
            ['kecamatan_code' => '13.71.04', 'code' => '13.71.04.1002', 'name' => 'Air Tawar Barat'],
            ['kecamatan_code' => '13.71.04', 'code' => '13.71.04.1003', 'name' => 'Ulak Karang Utara'],
            ['kecamatan_code' => '13.71.04', 'code' => '13.71.04.1004', 'name' => 'Ulak Karang Selatan'],
            ['kecamatan_code' => '13.71.04', 'code' => '13.71.04.1005', 'name' => 'Lolong Belanti'],
            ['kecamatan_code' => '13.71.04', 'code' => '13.71.04.1006', 'name' => 'Alai Parak Kopi'],
            ['kecamatan_code' => '13.71.04', 'code' => '13.71.04.1007', 'name' => 'Gunung Pangilun'],

            // Bungus Teluk Kabung (13.71.05)
            ['kecamatan_code' => '13.71.05', 'code' => '13.71.05.1001', 'name' => 'Bungus Timur'],
            ['kecamatan_code' => '13.71.05', 'code' => '13.71.05.1002', 'name' => 'Bungus Barat'],
            ['kecamatan_code' => '13.71.05', 'code' => '13.71.05.1003', 'name' => 'Bungus Selatan'],
            ['kecamatan_code' => '13.71.05', 'code' => '13.71.05.1004', 'name' => 'Teluk Kabung Utara'],
            ['kecamatan_code' => '13.71.05', 'code' => '13.71.05.1005', 'name' => 'Teluk Kabung Tengah'],
            ['kecamatan_code' => '13.71.05', 'code' => '13.71.05.1006', 'name' => 'Teluk Kabung Selatan'],

            // Lubuk Begalung (13.71.06)
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1001', 'name' => 'Cangkeh Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1002', 'name' => 'Kampung Baru Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1003', 'name' => 'Tanah Sirah Piai Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1004', 'name' => 'Tanjung Saba Pitameh Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1005', 'name' => 'Lubuk Begalung Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1006', 'name' => 'Gurun Laweh Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1007', 'name' => 'Tanjung Aua Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1008', 'name' => 'Koto Baru Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1009', 'name' => 'Banuaran Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1010', 'name' => 'Parak Laweh Pulau Aia Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1011', 'name' => 'Batung Taba Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1012', 'name' => 'Pegambiran Ampalu Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1013', 'name' => 'Pampangan Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1014', 'name' => 'Gates Nan XX'],
            ['kecamatan_code' => '13.71.06', 'code' => '13.71.06.1015', 'name' => 'Kampung Jua Nan XX'],

            // Lubuk Kilangan (13.71.07)
            ['kecamatan_code' => '13.71.07', 'code' => '13.71.07.1001', 'name' => 'Indarung'],
            ['kecamatan_code' => '13.71.07', 'code' => '13.71.07.1002', 'name' => 'Padang Besi'],
            ['kecamatan_code' => '13.71.07', 'code' => '13.71.07.1003', 'name' => 'Batu Gadang'],
            ['kecamatan_code' => '13.71.07', 'code' => '13.71.07.1004', 'name' => 'Banda Buek'],
            ['kecamatan_code' => '13.71.07', 'code' => '13.71.07.1005', 'name' => 'Koto Lalang'],
            ['kecamatan_code' => '13.71.07', 'code' => '13.71.07.1006', 'name' => 'Baringin'],
            ['kecamatan_code' => '13.71.07', 'code' => '13.71.07.1007', 'name' => 'Tarantang'],

            // Pauh (13.71.08)
            ['kecamatan_code' => '13.71.08', 'code' => '13.71.08.1001', 'name' => 'Limau Manis'],
            ['kecamatan_code' => '13.71.08', 'code' => '13.71.08.1002', 'name' => 'Koto Lua'],
            ['kecamatan_code' => '13.71.08', 'code' => '13.71.08.1003', 'name' => 'Limau Manis Selatan'],
            ['kecamatan_code' => '13.71.08', 'code' => '13.71.08.1004', 'name' => 'Piai Tangah'],
            ['kecamatan_code' => '13.71.08', 'code' => '13.71.08.1005', 'name' => 'Cupak Tangah'],
            ['kecamatan_code' => '13.71.08', 'code' => '13.71.08.1006', 'name' => 'Pisang'],
            ['kecamatan_code' => '13.71.08', 'code' => '13.71.08.1007', 'name' => 'Binuang Kampung Dalam'],
            ['kecamatan_code' => '13.71.08', 'code' => '13.71.08.1008', 'name' => 'Kapalo Koto'],
            ['kecamatan_code' => '13.71.08', 'code' => '13.71.08.1009', 'name' => 'Lambung Bukit'],

            // Kuranji (13.71.09)
            ['kecamatan_code' => '13.71.09', 'code' => '13.71.09.1001', 'name' => 'Pasar Ambacang'],
            ['kecamatan_code' => '13.71.09', 'code' => '13.71.09.1002', 'name' => 'Anduring'],
            ['kecamatan_code' => '13.71.09', 'code' => '13.71.09.1003', 'name' => 'Lubuk Lintah'],
            ['kecamatan_code' => '13.71.09', 'code' => '13.71.09.1004', 'name' => 'Ampang'],
            ['kecamatan_code' => '13.71.09', 'code' => '13.71.09.1005', 'name' => 'Kalumbuk'],
            ['kecamatan_code' => '13.71.09', 'code' => '13.71.09.1006', 'name' => 'Korong Gadang'],
            ['kecamatan_code' => '13.71.09', 'code' => '13.71.09.1007', 'name' => 'Kuranji'],
            ['kecamatan_code' => '13.71.09', 'code' => '13.71.09.1008', 'name' => 'Gunung Sarik'],
            ['kecamatan_code' => '13.71.09', 'code' => '13.71.09.1009', 'name' => 'Sungai Sapih'],

            // Nanggalo (13.71.10)
            ['kecamatan_code' => '13.71.10', 'code' => '13.71.10.1001', 'name' => 'Surau Gadang'],
            ['kecamatan_code' => '13.71.10', 'code' => '13.71.10.1002', 'name' => 'Kampung Olo'],
            ['kecamatan_code' => '13.71.10', 'code' => '13.71.10.1003', 'name' => 'Kurao Pagang'],
            ['kecamatan_code' => '13.71.10', 'code' => '13.71.10.1004', 'name' => 'Gurun Laweh'],
            ['kecamatan_code' => '13.71.10', 'code' => '13.71.10.1005', 'name' => 'Tabiang Banda Gadang'],
            ['kecamatan_code' => '13.71.10', 'code' => '13.71.10.1006', 'name' => 'Kampung Lapai'],

            // Koto Tangah (13.71.11)
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1001', 'name' => 'Balai Gadang'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1002', 'name' => 'Lubuk Minturun'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1003', 'name' => 'Aie Pacah'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1004', 'name' => 'Dadok Tunggul Hitam'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1005', 'name' => 'Koto Panjang Ikua Koto'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1006', 'name' => 'Koto Pulai'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1007', 'name' => 'Batipuh Panjang'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1008', 'name' => 'Padang Sarai'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1009', 'name' => 'Lubuk Buaya'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1010', 'name' => 'Batang Kabung Ganting'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1011', 'name' => 'Bungo Pasang'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1012', 'name' => 'Parupuk Tabing'],
            ['kecamatan_code' => '13.71.11', 'code' => '13.71.11.1013', 'name' => 'Pasie Nan Tigo'],
        ];

        // Karena data kelurahan cukup besar, kita gunakan chunk insert
        // untuk menghemat memory dan mengoptimasi eksekusi kueri
        $chunkedData = array_chunk($data, 50);
        
        foreach ($chunkedData as $chunk) {
            $kelurahan = array_map(function ($item) use ($now) {
                $item['created_at'] = $now;
                $item['updated_at'] = $now;
                return $item;
            }, $chunk);
            
            DB::table('kelurahan')->insert($kelurahan);
        }
    }
}