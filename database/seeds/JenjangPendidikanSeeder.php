<?php

use App\Models\JenjangPendidikan;
use Illuminate\Database\Seeder;

class JenjangPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pendidikan = [
            ['jenjang_pendidikan'  =>  'TK'],
            ['jenjang_pendidikan'  =>  'SD'],
            ['jenjang_pendidikan'  =>  'SMP'],
            ['jenjang_pendidikan'  =>  'SMA/SMK/SMU'],
            ['jenjang_pendidikan'  =>  'Perguruan Tinggi'],
        ];

        JenjangPendidikan::insert($pendidikan);
    }
}
