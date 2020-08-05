<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $pics = ["profileImages/player1.png", "profileImages/player2.png", "profileImages/player3.png", "profileImages/player4.png",
        "profileImages/player5.png", "profileImages/player6.png", "profileImages/player9.png", "profileImages/player10.png",
        "profileImages/player11.png", "profileImages/player12.png", "profileImages/player13.png", "profileImages/player14.png",
        "profileImages/player15.png", "profileImages/player16.png", "profileImages/player17.png", "profileImages/player18.png",
        "profileImages/player19.png", "blankProfile.png"];
    return [
        'name' => $faker->name,
        'accountType' => $faker->randomElement(["M", "P"]),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'profileImage' => $faker->randomElement($pics),
        'remember_token' => Str::random(10),
    ];
});
