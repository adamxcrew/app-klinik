<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(PoliklinikSeeder::class);
        $this->call(DokterSeeder::class);
        $this->call(WilayahIndonesiaSeeder::class);
    }
}
