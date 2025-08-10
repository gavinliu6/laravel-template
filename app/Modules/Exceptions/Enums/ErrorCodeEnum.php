<?php

namespace App\Modules\Exceptions\Enums;

enum ErrorCodeEnum: string
{
    case SUCCESS = 'success'; // Everything worked as expected.

    case UNAUTHENTICATED = 'unauthenticated'; // The user is not authenticated.
    case FORBIDDEN = 'forbidden'; // The user doesn’t have permissions to perform the request.
    case NOT_FOUND = 'not_found'; // The requested resource doesn’t exist.
    case METHOD_NOT_ALLOWED = 'method_not_allowed'; // The server does not implement the requested HTTP method.
    case UNPROCESSABLE_ENTITY = 'unprocessable_entity'; // The request action fails validation.
    case TOO_MANY_REQUESTS = 'too_many_requests'; // The API rate limit has been exceeded.
    case SERVER_ERROR = 'server_error'; // An internal server error has occurred.
}
