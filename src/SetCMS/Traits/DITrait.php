<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use Psr\Container\ContainerInterface;
use SetCMS\Application\Contract\ContractFactory;

trait DITrait
{

    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function factory(): ContractFactory
    {
        return $this->container->get(ContractFactory::class);
    }

}
