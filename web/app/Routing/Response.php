<?php


namespace App\Routing;


class Response
{
    protected string $status;
    protected array $attributes;

    public function __construct(string $status, array $attributes = [])
    {
        $this->status = $status;
        $this->attributes = [];
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function redirect($uri)
    {
        header('Location: ' . $uri);
    }

    public function getAttribute(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    public function setAttribute(string $key, mixed $value)
    {
        $this->attributes[$key] = $value;
    }
}