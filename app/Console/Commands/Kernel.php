<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Daily leaderboard update at 12 AM daily
        $schedule->command('leaderboards:update')->dailyAt('00:00');

        // Weekly mission assignment at at 12 AM Sunday
        $schedule->command('missions:assign')->weeklyAt('00:00');

        // Daily offer update at 12 AM daily & 12 AM Sunday weekly & 1st month 12 AM
        $schedule->command('offers:update')->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
