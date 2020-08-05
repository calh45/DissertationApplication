<?php

use App\Player;
use Illuminate\Database\Seeder;

class StrikerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $strikers = Player::all()->where("position", "FW");

        foreach ($strikers as $striker) {
            factory(App\Striker::class)->create(["playerId" => $striker->id, "shots" => ($striker->goals + 20), "shotsOnTarget" => ($striker->goals + 10)]);
        }
    }
}
