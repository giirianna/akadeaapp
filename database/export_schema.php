<?php
/**
 * Database Schema Exporter for MySQL
 * Run this locally to generate SQL file for hosting
 * 
 * Usage: php database/export_schema.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Change to MySQL connection for export
config(['database.default' => 'mysql']);

$sql = [];
$sql[] = "-- AkadeaApp Database Schema Export";
$sql[] = "-- Generated: " . date('Y-m-d H:i:s');
$sql[] = "-- WARNING: This will drop existing tables!";
$sql[] = "";
$sql[] = "SET FOREIGN_KEY_CHECKS=0;";
$sql[] = "";

// Get all tables from migrations
$tables = [
    'users',
    'password_reset_tokens',
    'sessions',
    'cache',
    'cache_locks',
    'jobs',
    'job_batches',
    'failed_jobs',
    'students',
    'teachers',
    'subjects',
    'teacher_subject',
    'spp_payments',
    'exams',
    'questions',
    'exam_submissions',
    'permissions',
    'roles',
    'model_has_permissions',
    'model_has_roles',
    'role_has_permissions',
];

foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        $sql[] = "-- Table: {$table}";
        $sql[] = "DROP TABLE IF EXISTS `{$table}`;";
        
        // Get CREATE TABLE statement
        $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
        if (!empty($createTable)) {
            $sql[] = $createTable[0]->{'Create Table'} . ";";
        }
        $sql[] = "";
    }
}

$sql[] = "SET FOREIGN_KEY_CHECKS=1;";

// Save to file
$filename = database_path('schema_export_' . date('Ymd_His') . '.sql');
file_put_contents($filename, implode("\n", $sql));

echo "✅ Schema exported to: {$filename}\n";
echo "📤 Upload this file to your hosting and import via phpMyAdmin\n";
