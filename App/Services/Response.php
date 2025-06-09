<?php

namespace App\Services;

class Response
{
    public function success(array $data): void
    {
        http_response_code(200);
        echo json_encode($data);
    }
    
    public function error(string $message, int $code = 400): void
    {
        http_response_code($code);
        echo json_encode(['error' => $message]);
    }
}