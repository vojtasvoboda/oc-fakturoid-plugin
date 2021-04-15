<?php namespace VojtaSvoboda\Fakturoid\Services;

use Fakturoid\Client;
use Fakturoid\Exception;
use Fakturoid\Response;
use VojtaSvoboda\Fakturoid\Models\Log;

class BaseService
{
    const HTTP_RESPONSE_SUCCESS = 200;

    const HTTP_RESPONSE_CREATED = 201;

    const HTTP_RESPONSE_NO_CONTENT = 204;

    /** @var Client $client */
    protected $client;

    /** @var Log $log */
    private $log;

    /**
     * @param Client $client
     * @param Log $log
     */
    public function __construct(Client $client, Log $log)
    {
        $this->client = $client;
        $this->log = $log;
    }

    /**
     * Log Fakturoid event.
     *
     * @param string $method
     * @param Response $response
     */
    protected function logError($method, $params, Response $response)
    {
        $this->log->create([
            'level' => 'error',
            'request_method' => $method,
            'request_params' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'response_status_code' => $response->getStatusCode(),
            'response_headers' => json_encode($response->getHeaders(), JSON_UNESCAPED_UNICODE),
            'response_body' => json_encode($response->getBody(), JSON_UNESCAPED_UNICODE),
        ]);
    }

    protected function logException($method, $params, Exception $e)
    {
        $this->log->create([
            'level' => 'exception',
            'request_method' => $method,
            'request_params' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'response_status_code' => $e->getCode(),
            'response_headers' => null,
            'response_body' => json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE),
        ]);
    }
}
