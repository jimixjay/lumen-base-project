<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;


class InvalidParamsHttpException extends HttpException
{
    public function __construct(int $code = 0, string $message = null, Throwable $previous = null, array $headers = [])
    {
        parent::__construct(400, $message, $previous, $headers, $code);
    }
}
