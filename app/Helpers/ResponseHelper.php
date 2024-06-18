<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * @param string $status
     * @param string $message
     * @param array  $data
     *
     * @return \response
     */
    public static function success($status, $message, $data = null, $code = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($status = null, $message = null, $code = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $code);
    }
}
