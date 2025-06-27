<?php

declare(strict_types=1);

namespace UUA\Container;

use UUA\Container\Exception\ContainerNotFoundException;
use UUA\FactoryInterface;
use UUA\Factory;

class Container implements \Psr\Container\ContainerInterface
{

    /**
     * @var array<string, mixed>
     */
    protected array $assetsResolved = [];

    public function __construct(\Closure $assets)
    {
        $this->assetsResolved[spl_object_hash($this)] = $assets($this);
        $this->assetsResolved[FactoryInterface::class] = new Factory($this);
    }

    #[\Override]
    public function get(string $id): mixed
    {
        if (!isset($this->assetsResolved[$id])) {
            if (class_exists($id, true) ||  interface_exists($id, true)) {
                $this->assetsResolved[$id] = $this->factory()->make($id);
            } else {
                $this->assetsResolved[$id] = $this->assetsResolved[spl_object_hash($this)][$id] ?? null;
            }
        }


        if (!isset($this->assetsResolved[$id])) {
            throw new ContainerNotFoundException($id);
        }

        return $this->assetsResolved[$id];
    }

    protected function factory(): FactoryInterface
    {
        return $this->get(FactoryInterface::class);
    }

    #[\Override]
    public function has(string $id): bool
    {
        return isset($this->assets[$id]) || isset($this->assetsResolved[spl_object_hash($this)][$id]);
    }
}
