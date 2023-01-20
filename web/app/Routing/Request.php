<?php


namespace App\Routing;


class Request
{
    protected string $id;
    protected string $uri;
    protected string $type;
    protected array $args;
    protected array $files;

    public function __construct(string $requestId)
    {
        $this->id = $requestId;
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->type = strtolower($_SERVER['REQUEST_METHOD']);
        $this->args['get'] = $_GET;
        $this->args['post'] = $_POST;
        $this->files = $_FILES;
    }

    public function getRequestId(): string
    {
        return $this->id;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getType(): string
    {
        return $this->type;
    }
    public function getParams(string $type): array
    {
        return $this->args[$type];
    }

    public function getFiles(): array
    {
        return $this->files;
    }
}