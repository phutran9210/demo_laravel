<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ErrorResponse extends Exception
{
    protected $data;
    protected $statusCode;

    public function __construct($message = null, $data = [], $statusCode = 400)
    {
        parent::__construct($message);
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->getMessage(),
            'errors' => $this->data
        ], $this->statusCode);
    }
}
