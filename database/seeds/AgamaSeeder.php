<?php

use App\Models\Agama;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agama = [
            ['agama'  =>  'Islam'],
            ['agama'  =>  'Protestan'],
            ['agama'  =>  'Katolik'],
            ['agama'  =>  'Hindu'],
            ['agama'  =>  'Buddha'],
            ['agama'  =>  'Khonghucu'],
        ];

        Agama::insert($agama);
    }
}
