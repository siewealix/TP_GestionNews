<?php

namespace App\Core;

class Helpers
{
    public static function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    public static function url(string $path = ''): string
    {
        $base = rtrim($_ENV['APP_URL'] ?? '', '/');
        $path = '/' . ltrim($path, '/');
        return $base . $path;
    }

    public static function asset(string $path): string
    {
        return self::url('assets/' . ltrim($path, '/'));
    }

    public static function slugify(string $value): string
    {
        $value = preg_replace('~[^\pL\d]+~u', '-', $value);
        $value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        $value = preg_replace('~[^-\w]+~', '', $value);
        $value = trim($value, '-');
        $value = preg_replace('~-+~', '-', $value);
        return strtolower($value ?: 'n-a');
    }

    public static function redirect(string $path): void
    {
        header('Location: ' . self::url($path));
        exit;
    }

    public static function formatDate(?string $date): string
    {
        if (!$date) {
            return '';
        }
        return date('d/m/Y', strtotime($date));
    }
}
