<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponses
{
    /**
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public function sendErrors(string $message = null, mixed $data = [], int $code = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        $response = [
            'status' => false,
            'data' => $data,
            'message' => $message ? $message : __('apiResponse.error')
        ];
        return response()->json($response, $code);
    }
    /**
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public function sendResponse(string $message = null, mixed $data = [], int $code = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'status' => true,
            'data' => $data,
            'message' => $message ? $message : __('apiResponse.success')
        ];
        return response()->json($response, $code);
    }
    /**
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public function validationErrorsResponse(string $message = null, mixed $data = [], int $code = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        $response = [
            'status' => false,
            'data' => $data,
            'message' => $message ? $message : "Validation Errors"
        ];
        return response()->json($response, $code);
    }

    public function unauthenticatedResponse(): JsonResponse
    {
        $response = [
            'status' => false,
            'data' => [],
            'message' => "Invalid User"
        ];
        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }
}
