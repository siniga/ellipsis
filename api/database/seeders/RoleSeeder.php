<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            'name' => "Admin",
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => "user",
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 1,
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 2,
            'user_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 2,
            'user_id' => 3,
            'created_at' => \Carbon\Carbon::now()
        ]);


        

    }
}
