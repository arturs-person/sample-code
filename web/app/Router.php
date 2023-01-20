<?php

namespace App;

use App\Exceptions\UserNotAuthorizedException;
use App\Interfaces\Router as RouterInterface;
use App\Routing\Request;
use App\Routing\Response;
use Error;

class Router implements RouterInterface
{
    private array $routes;
    private array $middlewares;
    private array $globalMiddlewares;

    public function __construct(array $globalMiddlewares = [])
    {
        $this->globalMiddlewares = $globalMiddlewares;
    }

    public function register(
        string $method,
        string $route,
        callable|array $action,
        array $middlewares = []
    ): self {
        $this->routes[$method][$route] = $action;
        $this->middlewares[$method][$route] = $middlewares;

        return $this;
    }

    public function get(string $route, callable|array $action, array $middlewares = []): self
    {
        return $this->register('get', $route, $action, $middlewares);
    }

    public function post(string $route, callable|array $action, array $middlewares = []): self
    {
        return $this->register('post', $route, $action, $middlewares);
    }

    protected function applyMiddlewares(Request $request, Response $response, array $middlewares): Response
    {
        try {
            if($middlewares) {
                $pipeline = new Pipeline($middlewares);
                $response = $pipeline->run($request, $response);
            }
        } catch (UserNotAuthorizedException $error) {
            $response->redirect('/login');
        } catch (\Exception $error) {
            var_dump('Unknown Error', $error->getMessage());
            $response->setStatus('NOT OK');
        }

        return $response;
    }

    protected function applyGlobalMiddlewares(Request $request, Response $response): Response
    {
        return $this->applyMiddlewares($request, $response, $this->globalMiddlewares);
    }

    public function resolve(Request $request)
    {
        $uri = $request->getUri();
        $method = $request->getType();
        $route = explode('?', $uri)[0];
        $action = $this->routes[$method][$route] ?? null;

        $middlewares = $this->middlewares[$method][$route] ?? [];
        $response = new Response('OK');
        if (!$route || !$action) {
            throw new Error('Route Not Found');
        }
        $response = $this->applyGlobalMiddlewares($request, $response);
        $response = $this->applyMiddlewares($request, $response, $middlewares);

        if ($response->getStatus() === 'NOT OK') {
            return $response;
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $classInstance = new $class($request, $response, App::$entityManager);

                if (method_exists($classInstance, $method)) {

                    return call_user_func_array([$classInstance, $method], []);
                }
            }
        }
    }
}