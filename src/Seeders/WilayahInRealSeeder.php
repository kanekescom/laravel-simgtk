<?php

namespace Kanekescom\Simgtk\Seeders;

use Illuminate\Database\Seeder;
use Kanekescom\Simgtk\Models\Wilayah;

class WilayahInRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->data()->each(function ($wilayah) {
            Wilayah::create($wilayah);
        });
    }

    public function data(): \Illuminate\Support\Collection
    {
        return collect([
            ['kode' => '36.02.01', 'nama' => 'Malingping'],
            ['kode' => '36.02.02', 'nama' => 'Panggarangan'],
            ['kode' => '36.02.03', 'nama' => 'Bayah'],
            ['kode' => '36.02.04', 'nama' => 'Cipanas'],
            ['kode' => '36.02.05', 'nama' => 'Muncang'],
            ['kode' => '36.02.06', 'nama' => 'Leuwidamar'],
            ['kode' => '36.02.07', 'nama' => 'Bojongmanik'],
            ['kode' => '36.02.08', 'nama' => 'Gunungkencana'],
            ['kode' => '36.02.09', 'nama' => 'Banjarsari'],
            ['kode' => '36.02.10', 'nama' => 'Cileles'],
            ['kode' => '36.02.11', 'nama' => 'Cimarga'],
            ['kode' => '36.02.12', 'nama' => 'Sajira'],
            ['kode' => '36.02.13', 'nama' => 'Maja'],
            ['kode' => '36.02.14', 'nama' => 'Rangkasbitung'],
            ['kode' => '36.02.15', 'nama' => 'Warunggunung'],
            ['kode' => '36.02.16', 'nama' => 'Cijaku'],
            ['kode' => '36.02.17', 'nama' => 'Cikulur'],
            ['kode' => '36.02.18', 'nama' => 'Cibadak'],
            ['kode' => '36.02.19', 'nama' => 'Cibeber'],
            ['kode' => '36.02.20', 'nama' => 'Cilograng'],
            ['kode' => '36.02.21', 'nama' => 'Wanasalam'],
            ['kode' => '36.02.22', 'nama' => 'Sobang'],
            ['kode' => '36.02.23', 'nama' => 'Curugbitung'],
            ['kode' => '36.02.24', 'nama' => 'Kalanganyar'],
            ['kode' => '36.02.25', 'nama' => 'Lebakgedong'],
            ['kode' => '36.02.26', 'nama' => 'Cihara'],
            ['kode' => '36.02.27', 'nama' => 'Cirinten'],
            ['kode' => '36.02.28', 'nama' => 'Cigemlong'],
        ]);
    }
}
