<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected  $model = \App\Models\Book::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'title' => $this->faker->word(),
            'author' => $this->faker->name(),

            // 'genre_id' => $this->faker->genre_id(),
        'genre_id' => function () {
            // return factory(\App\Models\Genre::class)->create()->id;
            return \App\Models\Genre::factory()->create()->id;
        },
        // $this->faker->image(storage_path('photos'), 300, 300)
        ];
    }
}
