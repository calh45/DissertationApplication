<?php

use App\Player;
use Illuminate\Database\Seeder;

class DefenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defenders = Player::all()->where("position", "DF");

        foreach ($defenders as $defender) {
            factory(App\Defender::class)->create(["playerId" => $defender->id, "cleanSheets" => rand(1, $defender->appearances)]);
        }
    }
}
