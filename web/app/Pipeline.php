<?php


namespace App;


use App\Routing\Request;
use App\Routing\Response;

class Pipeline
{
    private array $middlewares;

    public function __construct(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function run(Request $request, Response $response)
    {
        foreach ($this->middlewares as $middleware) {
            $response = $this->handle($request, $response, $middleware);
        }

        return $response;
    }

    public function handle($request, $response, $middleware)
    {
        if ($middleware !== null) {
            $response = $middleware->handle($request, $response);
        }

        return $response;
    }
}
