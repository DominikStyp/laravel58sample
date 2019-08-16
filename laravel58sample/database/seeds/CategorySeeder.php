<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 50)->create()->each(function ($category) {
            $tagsIds = [
                mt_rand(21, 30),
                mt_rand(21, 30),
                mt_rand(21, 30),
            ];
            /** @var $category Category */
            $category->tags()->attach($tagsIds);
        });
    }
}
