<?php

function responseError($errorCode, $errorMessage, $exception, $httpStatusCode = 500)
{
    $responseArray = [
        'error_code'    => $errorCode,
        'msg'          => $errorMessage,
        'msg_complete' => $exception->getMessage(),
        'trace'        => $exception->getTraceAsString(),
    ];

    return response()->json([
                                'error' => $responseArray,
                            ]
        ,
                            $httpStatusCode);
}

function composerAppVersion()
{
    $composer = json_decode(file_get_contents(base_path('composer.json')), true);

    return $composer['version'] ?? '';
}
