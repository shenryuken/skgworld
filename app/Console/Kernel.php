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
        // \App\Console\Commands\Inspire::class,
        Commands\CalculateAllBonus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('backup:run --only-db')
                    ->dailyAt('16:52');
        $schedule->command('backup:run')
                    ->weekly();
        //  $schedule->command('calculate:allbonus')
        // ->monthlyOn(2,'19:22');
        $schedule->call('App\Http\Controllers\WalletHistoryController@backupWalletDetails')->monthlyOn(05,'16:52');
        $schedule->call('App\Http\Controllers\BonusController@calculate_end_month_bonus')->monthlyOn(05,'16:52');
                 

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
