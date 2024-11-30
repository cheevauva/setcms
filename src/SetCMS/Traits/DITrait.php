<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use Psr\Container\ContainerInterface;
use SetCMS\Contract\Factory;

trait DITrait
{

    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function factory(): Factory
    {
        return $this->container->get(Factory::class);
    }

}
