<?php

namespace App\Http\Middleware;

use App\Manager;
use App\Team;
use App\User;
use Closure;
use Illuminate\Support\Facades\App;


class ManagerCreate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $userAccount = User::all()->where("email", $request["email"])->first();
        $userNames = explode(" ", $userAccount->name);

        $managerToAdd = new Manager();
        $managerToAdd -> userId = $userAccount->id;
        $managerToAdd -> firstName = $userNames[0];
        $managerToAdd -> lastName = $userNames[1];
        $managerToAdd -> save();

        $addedManager = Manager::all()->where("userId", $userAccount->id)->first();
        $managersTeam = Team::all()->where("teamId", $request["teamId"])->where("managerEmail", $request["email"])->first();


        Team::all()->where("teamId", $managersTeam->teamId)->first()->update(["managerId" => $addedManager->id]);



        return $response;
    }


}
