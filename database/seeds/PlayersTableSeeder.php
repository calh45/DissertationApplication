<?php
$y = 1;

use App\Player;
use App\User;
use Illuminate\Database\Seeder;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        global $y;
        $y = $y + 1;


        factory(App\User::class, 200)->create(["accountType" => "P"])
            ->each(function ($user) {
                if($user->accountType == "P") {
                    global $y;
                    $user->player()->save(factory(App\Player::class)->create(["userId" => $user->id, "teamId" => $y]));


                    if($y === 16) {
                        $y = 1;
                    } else {
                        $y = $y + 1;
                    }
                }

            });
    }
}
