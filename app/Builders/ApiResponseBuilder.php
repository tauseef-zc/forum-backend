<?php

namespace App\Builders;

use App\Builders\Interfaces\BuilderInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class ApiResponseBuilder implements BuilderInterface
{
    /**
     * Returns formatted response with custom status code
     *
     * @param int $statusCode
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function customResponse(int $statusCode, string $action, string $message, array $payload = [], array $headers = []) : JsonResponse
    {
        return self::buildApiResponse($statusCode, $action, $message, $payload, $headers);
    }

    /**
     * Returns formatted ok success response
     *
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function okResponse(string $action, string $message = '', array $payload = [], array $headers = []) : JsonResponse
    {
        return self::buildApiResponse(200, $action, $message, $payload, $headers);
    }

    /**
     * Returns formatted bad request error response
     *
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function badRequestResponse(string $action, string $message = '', array $payload = [], array $headers = []) : JsonResponse
    {
        return self::buildApiResponse(400, $action, $message, $payload, $headers);
    }

    /**
     * Returns formatted unauthorized error response
     *
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function unauthorizedResponse(string $action, string $message = '', array $payload = [], array $headers = []) : JsonResponse
    {
        return self::buildApiResponse(401, $action, $message, $payload, $headers);
    }

    /**
     * Returns formatted not found error response
     *
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function notFoundResponse(string $action, string $message = '', array $payload = [], array $headers = []) : JsonResponse
    {
        return self::buildApiResponse(404, $action, $message, $payload, $headers);
    }

    /**
     * Returns formatted Internal error response
     *
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function errorResponse(string $action, string $message = '', array $payload = [], array $headers = []) : JsonResponse
    {
        return self::buildApiResponse(500, $action, $message, $payload, $headers);
    }

    /**
     * Returns formatted api response
     *
     * @param int $statusCode
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    private static function buildApiResponse(int $statusCode, string $action, string $message, array $payload = [], array $headers = []) : JsonResponse
    {
        $message = self::buildResponseMessage($statusCode, $message);
        $body = self::buildResponseBody($statusCode, $action, $message, $payload);
        return Response::json($body, $statusCode);
    }

    /**
     * Returns default message value correspond to the stats code
     *
     * @param int $statusCode
     * @param string $message
     *
     * @return string
     */
    private static function buildResponseMessage(int $statusCode, string $message) : string
    {
        if ($message) {
            return $message;
        }

        $resMessage = "";

        switch ($statusCode) {
            case 200: $resMessage = 'Ok' ;
                break;
            case 400: $resMessage = 'Bad Request';
                break;
            case 401: $resMessage = 'Unauthorized';
                break;
            case 404: $resMessage = 'Resource Not Found';
                break;
            case 500: $resMessage = 'Internal Server Error';
        }

        return $resMessage;
    }

    /**
     * Returns formatted response body
     *
     * @param int $statusCode
     * @param string $action
     * @param string $message
     * @param array $payload
     *
     * @return array
     */
    private static function buildResponseBody(int $statusCode, string $action, string $message, array $payload) : array
    {
        $body = [
            'code'  => $statusCode,
            'action' => $action,
            'message' => $message,
        ];

        if ($payload) {
            if ($statusCode < 300 && $statusCode >= 200) {
                $body['data'] = $payload;
            } else {
                $body['errors'] = $payload;
            }
        }

        return $body;
    }
}
