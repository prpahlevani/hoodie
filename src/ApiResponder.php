<?php

namespace Motrack\Hoodie;

use Error;
use Throwable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Motrack\Hoodie\Interfaces\ApiResponderInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResponder implements ApiResponderInterface
{
    public function respondWithResource(JsonResource $resource, $message = null, int $statusCode = 200, array $headers = []): JsonResponse
    {
        // https://laracasts.com/discuss/channels/laravel/pagination-data-missing-from-api-resource
        return $this->apiResponse(
            [
                'success' => true,
                'result' => $resource,
                'message' => $message
            ], $statusCode, $headers
        );
    }

    public function respondWithResourceCollection(ResourceCollection $resourceCollection, $message = null, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => true,
                'message' => $message,
                'result' => $resourceCollection->response()->getData()
            ], $statusCode, $headers
        );
    }

    public function respondSuccess($message = null, $statusCode = 200, $headers = []): JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => true,
                'message' => $message
            ], $statusCode, $headers
        );
    }

    public function respondError($message, int $statusCode = 400, Throwable|Exception|Error $exception = null, int $error_code = 1): JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $message ?? 'There was an internal error, Please try again later',
                'exception' => $exception,
                'error_code' => $error_code
            ], $statusCode
        );
    }

    public function respondValidationErrors(ValidationException $exception, int $statusCode = 422): JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors()
            ],
            $statusCode
        );
    }

    protected function apiResponse(array $data = [], int $statusCode = 200, array $headers = []): JsonResponse
    {
        $result = $this->parseGivenData($data, $statusCode, $headers);
        return response()->json(
            $result['content'], $result['statusCode'], $result['headers']
        );
    }

    protected function parseGivenData(array $data = [], int $statusCode = 200, array $headers = []): array
    {
        $responseStructure = [
            'success' => $data['success'],
            'message' => $data['message'] ?? null,
            'result' => $data['result'] ?? null,
        ];

        if (isset($data['errors'])) {
            $responseStructure['errors'] = $data['errors'];
        }
        if (isset($data['status'])) {
            $statusCode = $data['status'];
        }
        if (isset($data['exception']) && ($data['exception'] instanceof Error || $data['exception'] instanceof Exception)) {
            if (config('app.env') !== 'production') { // or app.debug == true
                $responseStructure['exception'] = [
                    'message' => $data['exception']->getMessage(),
                    'file' => $data['exception']->getFile(),
                    'line' => $data['exception']->getLine(),
                    'code' => $data['exception']->getCode(),
                    'trace' => $data['exception']->getTrace(),
                ];
            }

            if ($statusCode === 200) {
                $statusCode = 500;
            }
        }
        if ($data['success'] === false) {
            if (isset($data['error_code'])) {
                $responseStructure['error_code'] = $data['error_code'];
            } else {
                $responseStructure['error_code'] = 1;
            }
        }
        return ["content" => $responseStructure, "statusCode" => $statusCode, "headers" => $headers];
    }
}
