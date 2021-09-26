<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'      => 'administrator',
                'email'     => 'admin@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'admin'
            ],
            [
                'name'      => 'Akutansi',
                'email'     => 'akutansi@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'keuangan'
            ],
            [
                'name'      => 'Hrd',
                'email'     => 'hrd@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'hrd'
            ],
            [
                'name'      => 'Bagian Gudang',
                'email'     => 'gudang@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'bagian_gudang'
            ]
        ];

        User::insert($users);
    }
}
