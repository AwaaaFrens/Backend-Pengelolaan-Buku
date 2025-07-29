<?php

namespace App\Helpers;

class ApiResponseHelper
{
    public static function success($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($message = 'Error', $code = 400, $errors = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'error' => $errors
        ], $code);
    }
}