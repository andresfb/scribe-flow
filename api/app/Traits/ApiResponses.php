<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    protected function ok(string $message, array $data = []): JsonResponse
    {
        return $this->response($message, $data, 200);
    }

    protected function error(string $message, array $data = [], int $status = 400): JsonResponse
    {
        return $this->response($message, $data, max($status, 400));
    }

    protected function response(string $message, array $data, int $status): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $status);
    }
}
