<?php

use App\Commit;
use App\Repository;
use Faker\Generator as Faker;

$factory->define(Commit::class, function (Faker $faker) {
    return [
        'repository_id' => function () {
            return factory(Repository::class)->create()->id;
        },
        'uid' => $faker->md5,
        'message' => $faker->sentence,
        'timestamp' => $faker->iso8601($max = 'now'),
        'author' => json_encode([
            'name' => $faker->name,
            'email' => $faker->email,
            'username' => $faker->userName,
        ]),
    ];
});
