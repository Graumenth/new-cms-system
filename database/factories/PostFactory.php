<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Post::class;

    public function definition()
    {
        return [
            'user_id' => Post::factory(User::class),
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph(rand(10,15), true),
            'post_image' => $this->faker->imageUrl('900', '300')
        ];
    }
}
