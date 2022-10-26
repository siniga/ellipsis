<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DB;

class BookSeeder extends Seeder
{
    use HasFactory;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('books')->insert([
            'title' => "The eye witness",
            'author'=>"Jimmy Jones",
            'image' =>"",
            'genre_id'=>1,
        ]);
  
    }
}
