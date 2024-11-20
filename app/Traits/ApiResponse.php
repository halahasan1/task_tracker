<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Success response with data
     *
     * @param $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $message = 'Success')
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 200);
    }

    /**
     * Error response
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message = 'Error', $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
