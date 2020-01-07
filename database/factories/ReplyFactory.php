<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {

    $dateTime = $faker->dateTimeThisMonth();

    return [
        'content' => $faker->sentence(),
        'created_at' => $dateTime,
        'updated_at' => $dateTime,
    ];
});
