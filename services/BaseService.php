<?php namespace VojtaSvoboda\Fakturoid\Services;

use Exception;
use Fakturoid\Exception\RequestException;
use Fakturoid\FakturoidManager;
use Fakturoid\Provider\Provider;
use Fakturoid\Response;
use VojtaSvoboda\Fakturoid\Models\Log;

abstract class BaseService
{
    const HTTP_RESPONSE_SUCCESS = 200;

    const HTTP_RESPONSE_CREATED = 201;

    const HTTP_RESPONSE_NO_CONTENT = 204;

    protected FakturoidManager $client;

    private Log $log;

    public function __construct(FakturoidManager $client, Log $log)
    {
        $this->client = $client;
        $this->log = $log;
    }

    abstract public function getProvider(): Provider;

    protected function logError($method, $params, Response $response)
    {
        $body = (string) $response->getBody();

        $this->log->create([
            'level' => 'error',
            'request_method' => $method,
            'request_params' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'response_status_code' => $response->getStatusCode(),
            'response_headers' => json_encode($response->getHeaders(), JSON_UNESCAPED_UNICODE),
            'response_body' => json_encode($body, JSON_UNESCAPED_UNICODE),
        ]);
    }

    protected function logException($method, $params, Exception $e)
    {
        $body = $e->getMessage();

        if ($e instanceof RequestException) {
            $body = (string) $e->getResponse()->getBody();
        }

        $this->log->create([
            'level' => 'exception',
            'request_method' => $method,
            'request_params' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'response_status_code' => $e->getCode(),
            'response_headers' => null,
            'response_body' => json_encode($body, JSON_UNESCAPED_UNICODE),
        ]);
    }
}
