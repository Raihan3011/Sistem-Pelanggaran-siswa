<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MonthlyBackup extends Command
{
    protected $signature = 'backup:monthly';
    protected $description = 'Monthly archive database backup';

    public function handle()
    {
        try {
            $date = date('Ymd_His');
            $month = date('Y_m');
            
            $backupDir = storage_path('app/backups/monthly');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            $filename = "monthly_archive_{$month}_{$date}.sql.gz";
            $filepath = "{$backupDir}/{$filename}";
            
            $tables = \DB::select('SHOW TABLES');
            $sql = "-- Monthly Archive Backup {$date}\n\n";
            
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
            
            $this->info("Monthly archive backup created: {$filename}");
            return 0;
        } catch (\Exception $e) {
            $this->error("Backup failed: " . $e->getMessage());
            return 1;
        }
    }
}
