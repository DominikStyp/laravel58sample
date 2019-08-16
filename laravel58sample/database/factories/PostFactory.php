<?php

/* @var $factory Factory */

use App\Models\Post;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'content' => $faker->realText(),
        'user_id' => mt_rand(1, max(User::count(), 1))
    ];
});
