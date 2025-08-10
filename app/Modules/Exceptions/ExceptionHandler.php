<?php

namespace App\Modules\Exceptions;

use App\Modules\Exceptions\Enums\ErrorCodeEnum;
use Exception;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class ExceptionHandler
{
    /**
     * Return a JSON response for the given exception.
     */
    public static function render(Exception $e): JsonResponse
    {
        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return response()->error(
                code: ErrorCodeEnum::UNAUTHENTICATED,
                msg: 'Unable to authenticate you.',
                status: Response::HTTP_FORBIDDEN
            );
        }

        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException
            || $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->error(
                code: ErrorCodeEnum::NOT_FOUND,
                msg: is_production() ? 'The requested resource doesn’t exist.' : $e->getMessage(),
                status: Response::HTTP_NOT_FOUND
            );
        }

        if ($e instanceof \Symfony\Component\Routing\Exception\RouteNotFoundException) {
            return response()->error(
                code: ErrorCodeEnum::NOT_FOUND,
                msg: $e->getMessage(),
                status: Response::HTTP_NOT_FOUND
            );
        }

        if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return response()->error(
                code: ErrorCodeEnum::METHOD_NOT_ALLOWED,
                msg: $e->getMessage(),
                status: Response::HTTP_METHOD_NOT_ALLOWED
            );
        }

        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return response()->error(
                code: ErrorCodeEnum::UNPROCESSABLE_ENTITY,
                msg: $e->validator->errors()->first(),
                status: Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if ($e instanceof ThrottleRequestsException) {
            return response()->error(
                code: ErrorCodeEnum::TOO_MANY_REQUESTS,
                msg: $e->getMessage(),
                status: Response::HTTP_TOO_MANY_REQUESTS
            );
        }

        if ($e instanceof \App\Modules\Exceptions\BusinessException) {
            return response()->error(
                code: $e->getErrorCode(),
                msg: $e->getMessage(),
            );
        }

        return response()->error(
            code: ErrorCodeEnum::SERVER_ERROR,
            msg: is_production() ? 'Something unexpected occurred on the server.' : $e->getMessage(),
            status: Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
