<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Container\ContainerInterface;
use SetCMS\FactoryInterface;

trait DITrait
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    private function factory(): FactoryInterface
    {
        return $this->container->get(FactoryInterface::class);
    }

}
