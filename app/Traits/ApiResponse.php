<?php

namespace App\Traits;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

Trait ApiResponse
{
    protected function successResponse($data, $message = '', $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success'  => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
    protected function errorResponse($message = '', $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success'  => false,
            'message' => $message
        ], $code);
    }

    protected function perPage(int $default = 10, int $max = 100): int
    {
        $perPage = (int) request('per_page', $default);
        return min(max($perPage > 0 ? $perPage : $default, 1), $max);
    }


}
