<?php

namespace App\Services\Http;

use App\Exceptions\SimyoConnectionException;
use App\Exceptions\SimyoException;
use App\Services\Soap\Helpers\SoapResponse;
use JetBrains\PhpStorm\ArrayShape;
use stdClass;

abstract class RequestAssembler
{

    protected $requestBody;
    protected $logComplete = false;

    public function __construct(protected string $endpoint)
    {
    }

    public function getRequestBodyAsArray()
    {
        return json_decode(json_encode($this->requestBody), true);
    }

    public function activeCompleteLog()
    {
        $this->logComplete = true;
    }

    public function requestBody()
    {
        return $this->requestBody;
    }

    protected function addElementToObjectIfNotNull(string $elementName, $value): void
    {
        if (is_null($value)) {
            return;
        }

        if (is_bool($value)) {
            $value = $value ? 1 : 0;
        }

        $this->requestBody->{$elementName} = $value;
    }

    protected function addElementToSubObjectIfNotNull(stdClass $subObject, string $elementName, $value): void
    {
        if (is_null($value)) {
            return;
        }

        if (is_bool($value)) {
            $value = $value ? 1 : 0;
        }

        $subObject->{$elementName} = $value;
    }

    protected function addElementToArrayIfNotNull(array &$array, string $elementName, $value): void
    {
        if (is_null($value)) {
            return;
        }

        if (is_bool($value)) {
            $value = $value ? 1 : 0;
        }

        $array[$elementName] = $value;
    }

    protected function getMockResponse()
    {
        return null;
    }

    #[ArrayShape([
        'uri'     => "string",
        'method'  => "string",
        'env'     => "string",
        "headers" => "string",
        'params'  => "string",
        'body'    => "null",
        'debug'   => "int",
    ])] protected function generateProxyParams(
        string       $endpoint,
        string       $method,
        string       $headers,
        string|array $body,
        int          $debug = 1): array
    {
        return [
            'uri'     => $endpoint,
            'method'  => $method,
            'env'     => 'UAT',
            "headers" => $headers,
            'params'  => is_array($body) ? json_encode($body) : $body,
            'body'    => null,
            'debug'   => $debug,
        ];
    }

    protected function addQueryParams(): string
    {
        $queryParams = [];
        foreach ($this->requestBody as $key => $element) {
            $queryParams[] = $key . '=' . $element;
        }

        return '?' . implode('&', $queryParams);
    }

}
