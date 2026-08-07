<?php

namespace App\Core;

class Request
{
    public static function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public static function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($uri, '?');
        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }
        return rtrim($uri, '/') ?: '/';
    }

    public static function getBody(): array
    {
        $rawContent = file_get_contents('php://input');
        if (empty($rawContent)) {
            return $_POST;
        }

        $decoded = json_decode($rawContent, true);
        return is_array($decoded) ? $decoded : [];
    }
}
