<?php

declare(strict_types=1);

namespace SetCMS\Database;

use Psr\Container\ContainerInterface;

class MainConnection extends Connection
{

    public function createDriverParams(ContainerInterface $container): array
    {
        $env = $container->get('env');
        $basePath = $container->get('basePath');
    }

}
