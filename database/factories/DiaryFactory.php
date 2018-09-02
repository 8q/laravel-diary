<?php

use Faker\Generator as Faker;

$factory->define(App\Diary::class, function (Faker $faker) {
    return [
        'datetime' => $faker->dateTime,
        'content' => $faker->realText($maxNbChars = 50, $indexSize = 2),
    ];
});
