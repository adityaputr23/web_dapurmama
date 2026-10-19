<?php

// Buat direktori temporary yang dibutuhkan Laravel saat di-deploy ke Vercel (serverless)
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $dirs = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }
}

// Force HTTPS di environment Vercel agar tidak ada mixed content blocking
$_SERVER['HTTPS'] = 'on';
$_SERVER['SERVER_PORT'] = 443;

// Set path database SQLite secara dinamis berdasarkan lokasi file ini
// Ini menghindari hardcode path yang bisa berbeda di tiap environment Vercel
$dbPath = realpath(__DIR__ . '/../database/database.sqlite');
if ($dbPath) {
    $_ENV['DB_DATABASE'] = $dbPath;
    $_SERVER['DB_DATABASE'] = $dbPath;
    putenv('DB_DATABASE=' . $dbPath);
}

// Teruskan request ke entrypoint Laravel public/index.php
require __DIR__ . '/../public/index.php';
