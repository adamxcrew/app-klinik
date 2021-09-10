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
            ['name'=>'administrator','email'=>'admin@gmail.com','password'=>Hash::make('password'),'role'=>'admin']
        ];

        User::insert($users);
    }
}
