<?php

// Vercel serverless entry point for Laravel

$root = dirname(__DIR__);

chdir($root);

// Auto-detect APP_URL from request headers
if (!isset($_ENV['APP_URL']) && !isset($_SERVER['APP_URL']) && isset($_SERVER['HTTP_HOST'])) {
    $scheme = isset($_SERVER['HTTP_X_FORWARDED_PROTO'])
        ? $_SERVER['HTTP_X_FORWARDED_PROTO']
        : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http');
    $appUrl = $scheme . '://' . $_SERVER['HTTP_HOST'];
    putenv("APP_URL=$appUrl");
    $_SERVER['APP_URL'] = $appUrl;
    $_ENV['APP_URL'] = $appUrl;
}

// Use /tmp for writable storage on Vercel's serverless platform
$tmpDir = sys_get_temp_dir();
$tmpStorage = $tmpDir . '/laravel-storage';

if (!is_dir($tmpStorage)) {
    @mkdir($tmpStorage, 0755, true);
    @mkdir($tmpStorage . '/framework/cache/data', 0755, true);
    @mkdir($tmpStorage . '/framework/sessions', 0755, true);
    @mkdir($tmpStorage . '/framework/views', 0755, true);
    @mkdir($tmpStorage . '/logs', 0755, true);
}

putenv("LARAVEL_STORAGE_PATH=$tmpStorage");
$_ENV['LARAVEL_STORAGE_PATH'] = $tmpStorage;

require $root . '/public/index.php';
