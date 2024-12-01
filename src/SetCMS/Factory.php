<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Container\ContainerInterface;
use DI\FactoryInterface as DIFactoryInterface;
use SetCMS\Application\Contract\ContractFactory;

class Factory implements ContractFactory
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
