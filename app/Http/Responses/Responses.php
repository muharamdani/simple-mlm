<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class Responses
{
    public static function Success(string $message, mixed $data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function Error(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null
        ], $statusCode);
    }
}
