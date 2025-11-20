<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $dailyBackups = $this->getBackups('daily');
        $weeklyBackups = $this->getBackups('weekly');
        $monthlyBackups = $this->getBackups('monthly');
        
        return view('backup.index', compact('dailyBackups', 'weeklyBackups', 'monthlyBackups'));
    }
    
    private function getBackups($type)
    {
        $backupDir = storage_path("app/backups/{$type}");
        if (!file_exists($backupDir)) {
            return [];
        }
        
        $files = glob("{$backupDir}/*.gz");
        $backups = [];
        
        foreach ($files as $file) {
            $backups[] = [
                'name' => basename($file),
                'size' => $this->formatBytes(filesize($file)),
                'date' => date('Y-m-d H:i:s', filemtime($file)),
                'path' => $file
            ];
        }
        
        usort($backups, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));
        
        return $backups;
    }
    
    private function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }
    
    public function create(Request $request)
    {
        $type = $request->input('type', 'daily');
        
        switch ($type) {
            case 'weekly':
                Artisan::call('backup:weekly');
                break;
            case 'monthly':
                Artisan::call('backup:monthly');
                break;
            default:
                Artisan::call('backup:daily');
        }
        
        return redirect()->route('backup.index')->with('success', 'Backup berhasil dibuat!');
    }
    
    public function download($type, $filename)
    {
        $filepath = storage_path("app/backups/{$type}/{$filename}");
        
        if (!file_exists($filepath)) {
            return redirect()->route('backup.index')->with('error', 'File backup tidak ditemukan!');
        }
        
        return response()->download($filepath);
    }
    
    public function delete($type, $filename)
    {
        $filepath = storage_path("app/backups/{$type}/{$filename}");
        
        if (file_exists($filepath)) {
            unlink($filepath);
            return redirect()->route('backup.index')->with('success', 'Backup berhasil dihapus!');
        }
        
        return redirect()->route('backup.index')->with('error', 'File backup tidak ditemukan!');
    }
    
    public function restore(Request $request, $type, $filename)
    {
        try {
            $filepath = storage_path("app/backups/{$type}/{$filename}");
            
            if (!file_exists($filepath)) {
                return redirect()->route('backup.index')->with('error', 'File backup tidak ditemukan!');
            }
            
            // Decompress dan baca SQL
            $sql = gzdecode(file_get_contents($filepath));
            
            if ($sql === false) {
                return redirect()->route('backup.index')->with('error', 'Gagal membaca file backup!');
            }
            
            // Disable foreign key checks
            \DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Execute SQL statements
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            foreach ($statements as $statement) {
                if (!empty($statement) && !str_starts_with($statement, '--')) {
                    \DB::statement($statement);
                }
            }
            
            // Enable foreign key checks
            \DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            return redirect()->route('backup.index')->with('success', 'Database berhasil di-restore!');
        } catch (\Exception $e) {
            return redirect()->route('backup.index')->with('error', 'Restore gagal: ' . $e->getMessage());
        }
    }
}
