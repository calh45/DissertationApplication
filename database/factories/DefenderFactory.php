<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Defender;
use App\Player;
use Faker\Generator as Faker;

$factory->define(Defender::class, function (Faker $faker) {
    $playerToUse = Player::all()->where("position", "DF")->random(1)->first();
    return [
        "playerId" => $playerToUse->id,
        "cleanSheets" => $faker->numberBetween($min=0, $max=$playerToUse->appearances),
        "aerialDuelsWon" => $faker->numberBetween($min=0, $max=70),
        "aerialDuelsLost" => $faker->numberBetween($min=0, $max=70),
        "tacklesAttempted" => $faker->numberBetween($min=50, $max=80),
        "tacklesWon" => $faker->numberBetween($min=0, $max=49),
        "shotsBlocked" => $faker->numberBetween($min=0, $max=40),
        "pensGivenAway" => $faker->numberBetween($min=0, $max=10),
        "csScore" => 0,
        "aerialDuelScore" => 0,
        "tackleScore" => 0,
        "shotBlockedScore" => 0,
        "pensGivenScore" => 0,
        "foulsScore" => 0,
        "totalScore" => 0,
        "ballPlayScore" => 0,
        "attackingThreatScore" => 0,
    ];
});
