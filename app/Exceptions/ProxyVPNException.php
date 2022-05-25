<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;


class ProxyVPNException extends HttpException
{
    public function __construct(
        int       $code = 0,
        string    $message = null,
                  $httpStatus = 500,
        Throwable $previous = null,
        array     $headers = []
    )
    {
        parent::__construct($httpStatus, $message, $previous, $headers, $code);
    }
}
