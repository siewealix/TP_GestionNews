<?php

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
    spl_autoload_register(function ($class) {
        $prefix = 'App\\';
        $baseDir = __DIR__ . '/';
        if (str_starts_with($class, $prefix)) {
            $relativeClass = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
            if (file_exists($file)) {
                require $file;
            }
        }
    });
}

$envPath = dirname(__DIR__) . '/.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $value = trim($value, \"'\\\"\");
        $_ENV[$key] = $value;
    }
}

date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Europe/Paris');

session_start();

set_error_handler(function ($severity, $message, $file, $line) {
    error_log("[$severity] $message in $file:$line");
    if (!filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
        http_response_code(500);
        include __DIR__ . '/Views/errors/500.php';
        exit;
    }
});

set_exception_handler(function ($exception) {
    error_log($exception->getMessage());
    if (!filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
        http_response_code(500);
        include __DIR__ . '/Views/errors/500.php';
        exit;
    }
    throw $exception;
});
