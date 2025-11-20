<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [ 
        Commands\DailyBackup::class,
        Commands\WeeklyBackup::class,
        Commands\MonthlyBackup::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Daily incremental backup at 00:00
        $schedule->command('backup:daily')->dailyAt('00:00');
        
        // Weekly full backup on Sunday at 02:00
        $schedule->command('backup:weekly')->weeklyOn(0, '02:00');
        
        // Monthly archive backup on last day of month at 23:00
        $schedule->command('backup:monthly')->monthlyOn(28, '23:00');
        
        // Clean old backups daily at 03:00 (keep 30 days)
        $schedule->command('backup:clean')->dailyAt('03:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
