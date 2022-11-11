<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

class APIV1Controller extends Controller
{
    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function jsonResponse(?array $data): JsonResponse
    {
        return response()->json([
           'data' => $data,
        ]);
    }

    /**
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public function jsonErrorResponse(?string $message, int $code): JsonResponse
    {
        return response()->json([
           'error' => [
               'code' => $code,
               'message' => $message
           ]
        ]);
    }
}
