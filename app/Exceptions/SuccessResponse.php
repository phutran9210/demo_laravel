<?php

namespace App\Exceptions;

class SuccessResponse
{
    public static function create($message, $data = [], $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}
