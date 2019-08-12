<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'content' => $faker->realText(),
        'user_id' => mt_rand(1, max(User::count(), 1))
    ];
});
