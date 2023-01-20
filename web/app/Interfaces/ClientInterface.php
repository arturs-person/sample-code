<?php

namespace App\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    public function request(string $method, string $url, array $arguments): ResponseInterface;
}