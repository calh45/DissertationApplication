<?php

use App\Midfielder_Stat;
use App\Player;
use Illuminate\Database\Seeder;

class GoalkeeperTablerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goalkeepers = Player::all()->where("position", "GK");

        foreach ($goalkeepers as $goalkeeper) {
            factory(App\Goalkeeper::class)->create(["playerId" => $goalkeeper->id, "cleanSheets" => rand(1, $goalkeeper->appearances),
                "shotsFaced" => rand(100, 200),
                "shotsSaved" => rand(0, 99),
                "pensFaced" => rand(30, 40),
                "pensSaved" => rand(0, 29),
                "pensGivenAway" => rand(30, 40),
                "crossesClaimed" => rand(0, 100)]);
        }
    }
}
