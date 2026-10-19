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

// Teruskan request ke entrypoint Laravel public/index.php
require __DIR__ . '/../public/index.php';
