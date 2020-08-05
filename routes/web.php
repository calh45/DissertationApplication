<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/managerHome', "ManagerSideController@index")->name("managerHome");

Route::get('/playerHome', function () {
    return view('playerHome');
})->name("player.home");

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/registerClub', function () {
    return view("registerClub");
})->name('registerClub');

Route::get('/players/{id}', "PlayerController@show")->name("player");

Route::get("/notifications", "NotificationsController@index")->name("notifications");

Route::get("/managerFinances", "ManagerFinancesController@index")->name("managerFinances");

Route::get("/playerFees/{id}", "PlayerFeesController@index")->name("playerFees");

Route::get("/sendReminder/{id}", "PlayerFeesController@sendReminder")->name("sendReminder");

Route::get("/calendar/{year}", "CalendarController@index")->name("calendar");

Route::get("/calendarEvent/{id}", "CalendarEventController@index")->name("calendarEvent");

Route::get("/lineup/{eventId}", "LineupController@index")->name("lineup");

Route::get("/matchStats/{id}", "MatchStatisticsController@index")->name("matchStats");

Route::get("/squadStatistics", "SquadStatisticsController@index")->name("squadStatistics");

Route::get("/promotePlayer/{playerId}", "SquadStatisticsController@promotePlayer")->name("promote.player");

Route::get("/demotePlayer/{promotionId}", "SquadStatisticsController@demotePlayer")->name("demote.player");

Route::get("/allPlayers/{toOrder}", "AllPlayersController@index")->name("allPlayers");

Route::get("/targetCreate/{playerId}", "TargetCreateController@index")->name("target.create");

Route::get("/targetHome/{targetId}", "TargetController@index")->name("target");

Route::get("/allTargets", "allTargetsController@index")->name("allTargets");

Route::post("edit finances", "ManagerFinancesController@edit")->name("finances.edit");

Route::post("pay fee", "PlayerFeesController@payFee")->name("fee.pay");

Route::post("new event", "CalendarController@createEvent")->name("event.create");

Route::post("calendar change", "CalendarController@change")->name("calendar.change");

Route::post("/availabilityCreate/{id}", "AvailabilityController@create")->name("availability.create");

Route::post("/calendarEventDelete/{id}", "CalendarEventController@delete")->name("event.delete");

Route::post("/lineupCreate/{eventId}", "LineupController@create")->name("lineup.create");

Route::post("/statsUpdate/{lineupId}", "MatchStatisticsController@saveStats")->name("stats.update");

Route::post("/profilePicture", "PlayerController@saveImage")->name("picture.change");

Route::post("/fourCornerSave/{playerId}", "PlayerController@fourCornerUpdate")->name("fourCorner.update");

Route::post("/targetCreate/{playerId}", "TargetCreateController@create")->name("target.create");

Auth::routes();

Route::group(['middleware' => ['teamVerify', 'managerCreate']], function () {
    Route::post('register', [
        'as' => '',
        'uses' => 'Auth\RegisterController@register'
    ]);
});

Route::post("playerRegister", 'Auth\PlayerRegisterController@register')->middleware('playerCreate')->name("playerRegister");

Route::post("register clubs", "ClubRegisterController@create")->name("clubs.create");
