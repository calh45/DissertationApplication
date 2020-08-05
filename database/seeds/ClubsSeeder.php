<?php
$x = 1;

use App\Manager;
use Illuminate\Database\Seeder;

class ClubsSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        global $x;
        $x = $x+1;
        factory(App\Club::class, 4)->create()
            ->each(function ($club) {
                $teamNames = ['under9', 'under12', 'under15', 'under18', 'seniors'];

                global $x;
                foreach ($teamNames as $thisTeamName) {

                    $teamManager = Manager::all()->where("id", $x)->first();
                    $club->teams()->save(factory(App\Team::class)->create(['clubId' => $club->id, 'teamName' => $thisTeamName, 'managerId' => null, 'managerEmail' => "calvinhothi@yahoo.co.uk"]));
                    $x = $x+=1;
                }

            });
    }
}
