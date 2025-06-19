<?php

declare(strict_types=1);

namespace UUA;

use Psr\Container\ContainerInterface;

interface ContainerConstructInterface
{

    public function __construct(ContainerInterface $container);
}
