<?php

namespace App\Services\Http;

use Exception;
use GuzzleHttp\Psr7\Response;

final class DirectGuzzleHttpClient extends HttpClient
{
    /** @var Response $response */
    private $response;
    private $responseBody;

    public function __construct(array $guzzleClientConfig = [], $logChannel = null)
    {
        parent::__construct($guzzleClientConfig, $logChannel);
    }

    public function request(
        $method,
        $endpoint,
        $body = [],
        $options = [],
        $bodyType = self::BODY_TYPE_JSON,
        $debug = true
    ): self
    {
        if ($debug) {
            $this->setDebugger();
        }

        if (empty($options['timeout'])) {
            $options['timeout'] = config('app.http_default_TTL');
        }

        $this->response = $this->guzzleClient->request($method, $endpoint, $options);

        if ($this->response->getStatusCode() != 201 && $this->response->getStatusCode() != 200) {
            throw new Exception('Error response code ' . $this->response->getStatusCode());
        }

        return $this;
    }

    public function getResponseBody($asAssocArray = false)
    {
        $this->responseBody = (string)$this->response->getBody();
        $header             = $this->response->getHeader('content-type');

        if (!empty($header[0]) && 'application/json' == substr($header[0], 0, 16)) {

            $this->responseBody = json_decode($this->responseBody, $asAssocArray);
        }

        return $this->responseBody;
    }

}
