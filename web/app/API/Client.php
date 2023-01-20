<?php

namespace App\API;

use App\Interfaces\ClientInterface;
use GuzzleHttp\Client as RestApiClient;
use Psr\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
    public function __construct()
    {
        $this->apiClient = new RestApiClient();
    }

    public function request(string $method, string $url, array $arguments): ResponseInterface
    {
        return $this->apiClient->request($method, $url, $arguments);
    }
}