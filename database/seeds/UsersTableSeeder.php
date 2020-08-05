<?php

use App\Manager;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 20)->create(["accountType" => "M"])
            ->each(function ($user) {
                if($user->accountType == "M") {
                    $userName = explode(" ", $user->name);
                    $user->manager()->save(factory(App\Manager::class)->create(['userId' => $user->id, 'firstName' => $userName[0], 'lastName' => $userName[1]]));
                }
            });

    }
}
