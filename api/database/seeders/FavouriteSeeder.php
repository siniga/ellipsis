<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class FavouriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('favourites')->insert([
            'user_id'=>1,
            'book_id'=>1,
        ]);
    }
}
