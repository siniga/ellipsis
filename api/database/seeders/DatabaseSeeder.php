<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(FavouriteSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(LikeSeeder::class);

      
        // \App\Models\User::factory()->count(20)->create();
        \App\Models\Book::factory()->count(5000)->create();
        
        // factory(\App\Models\User::class, 50)->create();
        // factory(App\Models\Book::class, 200)->create();
       
    
    }
}
