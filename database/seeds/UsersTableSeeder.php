<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
               'name'=>'Admin',
               'email'=>'admin@mail.com',
               'email_verified_at' => now(),
               'password'=> bcrypt('12345678'),
               'remember_token' => Str::random(10),
            ],
            [
               'name'=>'Seller',
               'email'=>'seller@mail.com',
               'email_verified_at' => now(),
               'password'=> bcrypt('12345678'),
               'remember_token' => Str::random(10),
            ],            
            [
               'name'=>'User',
               'email'=>'user@mail.com',
               'email_verified_at' => now(),
               'password'=> bcrypt('12345678'),
               'remember_token' => Str::random(10),
            ]
        ];

        DB::table('users')->insert($users);
    }
}
