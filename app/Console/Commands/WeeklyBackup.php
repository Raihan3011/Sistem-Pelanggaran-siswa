<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WeeklyBackup extends Command
{
    protected $signature = 'backup:weekly';
    protected $description = 'Weekly full database backup';

    public function handle()
    {
        try {
            $date = date('Ymd_His');
            
            $backupDir = storage_path('app/backups/weekly');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            $filename = "weekly_full_backup_{$date}.sql.gz";
            $filepath = "{$backupDir}/{$filename}";
            
            $tables = \DB::select('SHOW TABLES');
            $sql = "-- Weekly Full Backup {$date}\n\n";
            
            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                
                $createTable = \DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
                $sql .= array_values((array)$createTable)[1] . ";\n\n";
                
                $rows = \DB::select("SELECT * FROM `{$tableName}`");
                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        $values = array_map(function($val) {
                            return is_null($val) ? 'NULL' : "'" . addslashes($val) . "'";
                        }, (array)$row);
                        $sql .= "INSERT INTO `{$tableName}` VALUES (" . implode(',', $values) . ");\n";
                    }
                    $sql .= "\n";
                }
            }
            
            file_put_contents($filepath, gzencode($sql, 9));
            
            $this->info("Weekly full backup created: {$filename}");
            return 0;
        } catch (\Exception $e) {
            $this->error("Backup failed: " . $e->getMessage());
            return 1;
        }
    }
}
