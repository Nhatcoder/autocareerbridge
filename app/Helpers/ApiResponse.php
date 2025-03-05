<?php

namespace App\Helpers;

/**
 * Return apiresponse success, error
 * @author TranVanNhat <tranvannhat7624@gmail.com>
 */
trait ApiResponse
{
    /**
     * Return API success response
     *
     * @param mixed $data
     * @param mixed $message
     * @param mixed $status HTTP status code (default: 200)
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function successResponse($data = [], $success = true, $message = "Success", $status = 200)
    {
        return response()->json([
            'success' => $success,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Return API error response
     *
     * @param mixed $message Error message to be returned
     * @param int $status HTTP status code (default: 400)
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($success = false, $message = "Error", $status = 400)
    {
        return response()->json([
            'success' => $success,
            'status' => $status,
            'message' => $message,
            'data' => null,
        ], $status);
    }
}
