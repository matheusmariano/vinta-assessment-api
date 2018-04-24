<?php

use App\User;
use App\Repository;
use Faker\Generator as Faker;

$factory->define(Repository::class, function (Faker $faker) {
    return [
        'name' => $faker->word . '/' . $faker->word,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
