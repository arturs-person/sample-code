<?php


namespace App\Interfaces;

use App\Routing\Request;

interface Router
{
    public function register(string $method, string $route, array|callable $action, array $middlewares = []): self;
    public function resolve(Request $request);
}