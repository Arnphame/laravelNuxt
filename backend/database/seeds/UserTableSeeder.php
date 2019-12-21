<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'email' => 'arnas@arnas.com',
            'name' => 'arnas',
            'password' => bcrypt('Arnas123'),
            'role' => 1,
            'games_played' => 0,
            'badge' => 'Bronze',
        ]);
    }
}
