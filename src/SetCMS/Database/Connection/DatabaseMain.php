<?php

declare(strict_types=1);

namespace SetCMS\Database\Connection;

use Psr\Container\ContainerInterface;

class DatabaseMain extends Database
{

    public function createDriverParams(ContainerInterface $container): array
    {
        $env = $container->get('env');
        $basePath = $container->get('basePath');


    }

}
