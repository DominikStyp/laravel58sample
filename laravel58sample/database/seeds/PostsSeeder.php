<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class, 1000)->create()->each(function ($post) {
                 $ids = [  mt_rand(1,50), mt_rand(1,50),
                           mt_rand(1,50), mt_rand(1,50),
                           mt_rand(1,50)
                 ];
                 $post->categories()->attach($ids);
        });
    }
}
