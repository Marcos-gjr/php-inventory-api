<?php

namespace App\Core;

class Response
{
    public static function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public static function error(string $message, int $statusCode = 400, array $details = []): void
    {
        $payload = [
            'status'  => 'error',
            'message' => $message,
        ];

        if (!empty($details)) {
            $payload['errors'] = $details;
        }

        self::json($payload, $statusCode);
    }
}
