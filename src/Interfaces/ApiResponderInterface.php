<?php

namespace Motrack\Hoodie\Interfaces;

use Error;
use Throwable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface ApiResponderInterface
{
    /**
     * Respond success with Resource.
     */
    public function respondWithResource(JsonResource $resource, $message = null, int $statusCode = 200, array $headers = []): JsonResponse;

    /**
     * Respond success with Collection.
     */
    public function respondWithResourceCollection(ResourceCollection $resourceCollection, $message = null, int $statusCode = 200, array $headers = []): JsonResponse;

    /**
     * Respond with success.
     */
    public function respondSuccess($message = null, $statusCode = 200, $headers = []): JsonResponse;

    /**
     * Respond with error.
     */
    public function respondError($message, int $statusCode = 400, Throwable|Exception|Error $exception = null, int $error_code = 1): JsonResponse;

    /**
     * Respond with validation error.
     */
    public function respondValidationErrors(ValidationException $exception, int $statusCode = 422): JsonResponse;
}
