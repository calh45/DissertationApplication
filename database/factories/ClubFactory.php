<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Club;
use Faker\Generator as Faker;

$factory->define(Club::class, function (Faker $faker) {
    return [
        'clubName' => $faker->randomElement(["Swindon Town fc", "Oxford United", "Walsall", "MK Dons", "Swansea City",
            "Southampton FC", "Arsenal"]),
        'clubCreator' => $faker->randomElement(["Jacob Roberts", "Sam Hurford", "Nathan Pelling", "Matt Ashman", "Rajan Hothi"])
    ];
});
