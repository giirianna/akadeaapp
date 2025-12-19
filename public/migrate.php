<?php
/**
 * Web-based Migration Runner
 * 
 * ⚠️ SECURITY WARNING: Delete this file after running migrations!
 * 
 * Usage: 
 * 1. Upload this file to your hosting's public directory
 * 2. Visit: https://yourdomain.com/migrate.php?secret=YOUR_SECRET_KEY
 * 3. DELETE this file immediately after use
 */

// Security: Change this to a random secret key
define('MIGRATION_SECRET', 'change-this-to-random-secret-key-12345');

// Check secret key
if (!isset($_GET['secret']) || $_GET['secret'] !== MIGRATION_SECRET) {
    die('❌ Unauthorized access');
}

// Load Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "<!DOCTYPE html>
<html>
<head>
    <title>Migration Runner</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #1e1e1e; color: #00ff00; }
        .success { color: #00ff00; }
        .error { color: #ff0000; }
        .warning { color: #ffaa00; }
        pre { background: #000; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🚀 Database Migration Runner</h1>
    <pre>";

try {
    // Run migrations
    echo "Running migrations...\n\n";
    
    ob_start();
    Artisan::call('migrate', [
        '--force' => true, // Force in production
    ]);
    $output = ob_get_clean();
    
    echo $output;
    
    echo "\n\n";
    echo "<span class='success'>✅ Migrations completed successfully!</span>\n";
    
    // Show current migration status
    echo "\n\n--- Migration Status ---\n";
    ob_start();
    Artisan::call('migrate:status');
    echo ob_get_clean();
    
} catch (Exception $e) {
    echo "<span class='error'>❌ Error: " . $e->getMessage() . "</span>\n";
    echo "\n\nStack trace:\n";
    echo $e->getTraceAsString();
}

echo "</pre>
    <hr>
    <p class='warning'>⚠️ <strong>IMPORTANT:</strong> Delete this file immediately after running migrations!</p>
    <p>Run this command via FTP or File Manager: <code>DELETE /public/migrate.php</code></p>
</body>
</html>";
