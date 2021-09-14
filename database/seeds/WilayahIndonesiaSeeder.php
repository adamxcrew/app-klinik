<?php

use Illuminate\Database\Seeder;

class WilayahIndonesiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = "database/seeds/sql/wilayah_administratif_indonesia.sql";
        $db = [
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE')
        ];
        
        exec("mysql --user={$db['username']} --password={$db['password']} --port={$db['port']} --host={$db['host']} --database {$db['database']} < $sql");
    }
}
