<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__ . '/www/'));
$dotenv->load();

return [
    'dbname' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_USER_PASSWORD'],
    'host' => $_ENV['DB_HOST'],
    'driver' => $_ENV['DB_CONNECTION'] ?? 'pdo_mysql'
];