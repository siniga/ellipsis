<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => "Khamis peter",
            'email'=>"admin@mail.com",
            'password'=>bcrypt(123456),
        ]);

        DB::table('users')->insert([
            'name' => "John Olvier",
            'email'=>"jan@mail.com",
            'password'=>bcrypt(123456),
        ]);

        DB::table('users')->insert([
            'name' => "Sin yang sam",
            'email'=>"sim@mail.com",
            'password'=>bcrypt(123456),
        ]);

    }
}
