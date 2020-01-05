<?php

use Illuminate\Database\Seeder;
use App\Helpers\Common;
use App\User;

class UserTableSeeder extends Seeder 
{
    public function run()
    {
        DB::table('users')->delete();
        User::create([
            'user_key' => Common::generateRandomString('users', 'user_key'),
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'user_type' => 1,
            'password' => Hash::make('123456')
        ]);
    }

}