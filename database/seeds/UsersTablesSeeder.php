<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's clear the users table first
        User::truncate();



        User::create([
            'name'    => 'Chong',
            'email'    => 'chong.bkksoft@gmail.com',
            'username'  => 'chong',
            'password'   =>  Hash::make('1234'),
            'remember_token' =>  str_random(10),
        ]);

        $faker = \Faker\Factory::create();

        // Let's make sure everyone has the same password and
        // let's hash it before the loop, or else our seeder
        // will be too slow.
        $password = Hash::make('admin');

        // And now let's generate a few dozen users for our app:
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'username' => $faker->username,
                'email' => $faker->email,
                'password' => $password,
                'remember_token' =>  str_random(10),
            ]);
        }
    }
}
