<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('comments')->insert([
            'body' => "This book was extremely boring, i cant lie",
            'user_id'=>1,
            'book_id'=>1,
        ]);
    }
}
