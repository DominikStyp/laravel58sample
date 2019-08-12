<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::table('categories')->truncate();
        DB::table('posts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->call(UsersSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PostsSeeder::class);

    }
}
