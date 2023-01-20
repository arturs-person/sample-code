<?php

namespace App;

use Psr\Container\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use App\Exceptions\NotFoundException;

class Container implements ContainerInterface
{
    private array $entries = [];

    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException('Class "' . $id . '" has no binding.');
        }

        $entry = $this->entries[$id];

        return $entry($this);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $concrete)
    {
        $this->entries[$id] = $concrete;
    }
}