<?php

namespace App\API;

use App\App;
use App\Interfaces\ClientInterface;
use App\Exceptions\NotImplementedException;

class ApiClient
{
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct(protected ClientInterface $client)
    {
        $this->apiKey = App::$config->api_key;
        $this->apiUrl = App::$config->api_url;
    }

    public function getUnits(array $carNumbers)
    {
        throw new NotImplementedException;
    }

    public function getHistoricalData(int $unitId, DateTime $dateTime)
    {
        throw new NotImplementedException;
    }
}