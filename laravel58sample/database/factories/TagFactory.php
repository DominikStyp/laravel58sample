<?php

/* @var $factory Factory */

use App\Model;
use App\Models\Tag;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Tag::class, function (Faker $faker) {
    $l = $faker->randomLetter;
    $n = $faker->randomNumber(2);
    return [
        'name' => "{$l}{$l}{$l}{$n}"
    ];
});
