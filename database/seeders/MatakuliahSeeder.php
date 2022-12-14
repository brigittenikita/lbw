<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\matakuliah;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents("https://ftisunpar.github.io/data/prasyarat.json");
        $parsedata = json_decode($data);

        foreach ($parsedata as $kuliah) {
            $wajib = $kuliah->wajib;
            if ($wajib == 0) {
                matakuliah::create(array(
                    'namaMataKuliah' => $kuliah->nama,
                    'kode' => $kuliah->kode,
                    'sks' => $kuliah->sks,
                    'semester' => $kuliah->semester,

                    'keterangan' => 'Pilihan',

                ));
            } else if ($wajib == 1) {
                matakuliah::create(array(
                    'namaMataKuliah' => $kuliah->nama,
                    'kode' => $kuliah->kode,
                    'sks' => $kuliah->sks,
                    'semester' => $kuliah->semester,

                    'keterangan' => 'Wajib',

                ));
            }
        }
    }
}
