<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Player;
use App\Team;
use App\User;
use Faker\Generator as Faker;

$factory->define(Player::class, function (Faker $faker) {
    return [
        'userId' => User::all()->random(1)->first()->id,
        'clubId' => 1,
        'teamId' => 1,
        'position' => $faker->randomElement(["GK", "DF", "MF", "FW"]),
        'age' => $faker->numberBetween($min=8, $max=35),
        'balance' => 0,
        'appearances' => $faker->numberBetween($min=30, $max=45),
        'yellowCards' => $faker->numberBetween($min=0, $max=20),
        'redCards' => $faker->numberBetween($min=0, $max=5),
        'goals' => $faker->numberBetween($min=0, $max=25),
        'assists' => $faker->numberBetween($min=0, $max=20),
        'passesAttempted' => $faker->numberBetween($min=100, $max=200),
        'passesCompleted' => $faker->numberBetween($min=0, $max=99),
        'fouls' => $faker->numberBetween($min=0, $max=25),
        'totalScore' => 0,
        'technical' => "",
        'psychological' => "",
        'physical' => "",
        'social' => "",

    ];
});
