<?php

declare(strict_types=1);

namespace UUA\Container;

use UUA\Container\Exception\ContainerNotFoundException;

class Container implements \Psr\Container\ContainerInterface
{

    /**
     * 
     * @param array<string|mixed> $assets
     */
    public function __construct(protected array $assets)
    {
        
    }

    #[\Override]
    public function get(string $id): mixed
    {
        if (isset($this->assets[$id]) && ($this->assets[$id] instanceof \Closure)) {
            $this->assets[$id] = $this->assets[$id]($this);
        }

        if (!isset($this->assets[$id]) && class_exists($id, true)) {
            $this->assets[$id] = new $id($this);
        }

        if (!isset($this->assets[$id])) {
            throw new ContainerNotFoundException($id);
        }

        return $this->assets[$id];
    }

    #[\Override]
    public function has(string $id): bool
    {
        return isset($this->assets[$id]);
    }
}
