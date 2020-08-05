<?php

use App\Player;
use Illuminate\Database\Seeder;

class MidfielderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $midfielders = Player::all()->where("position", "MF");

        foreach ($midfielders as $midfielder) {
            factory(App\Midfielder::class)->create(["playerId" => $midfielder->id]);
        }
    }
}
