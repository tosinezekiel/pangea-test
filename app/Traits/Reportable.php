<?php
namespace App\Traits;

trait Reportable
{
    public function successResponse(string $message, $data = null, int $statusCode = 200) : object
    {
        return response(['data' => $data, 'message' => $message], $statusCode);
    }

    public function errorResponse(string $message, int $statusCode = null) : object
    {
        return response(['message' => $message], $statusCode);
    }
}