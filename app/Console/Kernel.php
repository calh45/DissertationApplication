<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\applyYearFee',
        'App\Console\Commands\feeWeekNotification',
        'App\Console\Commands\performanceTracker',
        'App\Console\Commands\targetCheck'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command("apply:fee")->dailyAt("18:00");
        $schedule->command("fee:preNotification")->dailyAt("18:00");
        $schedule->command("goalkeeper:track")->dailyAt("18:00");
        $schedule->command("defender:track")->dailyAt("18:00");
        $schedule->command("midfielder:track")->dailyAt("18:00");
        $schedule->command("forward:track")->dailyAt("18:00");
        $schedule->command("target:check")->dailyAt("18:00");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
