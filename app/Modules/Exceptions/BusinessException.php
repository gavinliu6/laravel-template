<?php

namespace App\Modules\Exceptions;

use App\Modules\Exceptions\Enums\ErrorCodeEnum;
use Exception;

abstract class BusinessException extends Exception
{
    /**
     * Create a new business exception.
     */
    public function __construct(string $message, protected ErrorCodeEnum $errorCode)
    {
        parent::__construct($message);
    }

    /**
     * Gets the Exception error code.
     */
    public function getErrorCode(): ErrorCodeEnum
    {
        return $this->errorCode;
    }
}
