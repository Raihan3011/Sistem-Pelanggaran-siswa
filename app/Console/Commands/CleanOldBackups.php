<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanOldBackups extends Command
{
    protected $signature = 'backup:clean';
    protected $description = 'Clean old backups (keep 30 days)';

    public function handle()
    {
        $backupDir = storage_path('app/backups/daily');
        
        if (file_exists($backupDir)) {
            $files = glob("{$backupDir}/*.gz");
            $now = time();
            $deleted = 0;
            
            foreach ($files as $file) {
                if (is_file($file)) {
                    if ($now - filemtime($file) >= 30 * 24 * 3600) {
                        unlink($file);
                        $deleted++;
                    }
                }
            }
            
            $this->info("Cleaned {$deleted} old backup files (older than 30 days)");
        }
        
        return 0;
    }
}
