<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Container\ContainerInterface;

class Factory implements FactoryInterface
{

    private \DI\FactoryInterface $factory;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get(\DI\FactoryInterface::class);
    }

    public function make(string $name, array $parameters = []): object
    {
        return $this->factory->make($name, $parameters);
    }

}
