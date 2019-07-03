<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'admin',
            'email' => 'admin@site.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        User::create([
            'name' => 'user1',
            'email' => 'user1@site.com',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'name' => 'user2',
            'email' => 'user2@site.com',
            'password' => bcrypt('12345678'),
        ]);

    }
}
