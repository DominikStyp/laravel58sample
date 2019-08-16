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
        factory(Post::class, 300)->create()->each(function ($post) {
                 $categoriesIds = [  mt_rand(1, 50), mt_rand(1, 50),
                           mt_rand(1, 50), mt_rand(1, 50),
                           mt_rand(1, 50)
                 ];
                 $tagsIds = [
                     mt_rand(1, 20),
                     mt_rand(1, 20),
                     mt_rand(1, 20)
                 ];
                 /** @var $post Post */
                 $post->categories()->attach($categoriesIds);
                 $post->tags()->attach($tagsIds);
        });
    }
}
