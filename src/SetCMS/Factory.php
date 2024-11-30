<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Container\ContainerInterface;
use DI\FactoryInterface as DIFactoryInterface;
use SetCMS\Contract\Factory as FactoryInterface;

class Factory implements FactoryInterface
{

    use \SetCMS\Traits\AsTrait;

    private DIFactoryInterface $factory;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get(DIFactoryInterface::class);
    }

    public function make(string $name, array $parameters = []): object
    {
        return $this->factory->make($name, $parameters);
    }

}
