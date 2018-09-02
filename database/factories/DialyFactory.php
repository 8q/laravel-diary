<?php

use Faker\Generator as Faker;

$factory->define(App\Dialy::class, function (Faker $faker) {
    return [
        'datetime' => $faker->dateTime,
        'content' => $faker->text,
    ];
});
