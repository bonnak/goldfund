<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         Commands\ApproveEarning::class,
         Commands\DailyEarning::class,
         Commands\ExpireDeposit::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('earning:daily')
                 ->daily()
                 ->sendOutputTo(
                    'storage/logs/earning_daily' . Carbon::today()->format('Ymd') . '.log'
                )
                 ->emailOutputTo('chea.bonnak@gmail.com');

        $schedule->command('earning:approve')
                 ->daily()
                 ->sendOutputTo(
                    'storage/logs/earning_approve' . Carbon::today()->format('Ymd') . '.log'
                )
                 ->emailOutputTo('chea.bonnak@gmail.com');

        $schedule->command('earning:expire')
                 ->daily()
                 ->sendOutputTo(
                    'storage/logs/earning_expire' . Carbon::today()->format('Ymd') . '.log'
                )
                 ->emailOutputTo('chea.bonnak@gmail.com');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
