<?php

namespace App\Http\Middleware;

use App\Team;
use Closure;
use Illuminate\Support\Facades\DB;

class checkRegistration
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

        //Collect existing team model with entered id
        $existingTeams = DB::table("teams")->where("teamId", (int)$request["teamId"])->whereNull("managerId")->get();

        //If teams exist, verify the entered team code is correct, else display error
        if(count($existingTeams) > 0) {
            $teamToUse = $existingTeams->first();
            //Check entered email is equal to stored email for team
            if($request["email"] == $teamToUse->managerEmail) {
                return $next($request);
            }else {
                return redirect()->route('register')->withErrors(["Email did not match our records for this team"]);
            }
        }else {
            return redirect()->route('register')->withErrors(["Team code invalid OR manager for this team already exists"]);
        }
    }
}
