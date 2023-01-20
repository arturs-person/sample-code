<?php

namespace App;

class Config
{
    protected array $config;

    public function __construct(array $env)
    {
        $this->config = [
            'database' => [
                'host' => $env['DB_HOST'],
                'user' => $env['DB_USERNAME'],
                'password' => $env['DB_USER_PASSWORD'],
                'dbname' => $env['DB_NAME'],
                'driver' => $env['DB_CONNECTION'] ?? 'pdo_mysql'
            ],
            'api_key' => $env['API_KEY'],
            'api_url' => $env['API_URL']
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}