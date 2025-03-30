<?php

declare(strict_types=1);

namespace SetCMS\Application\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

abstract class DatabaseConnection implements \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;

    protected Connection $connection;

    public function getConnection(): Connection
    {
        if (isset($this->connection)) {
            return $this->connection;
        }

        $prefix = mb_strtoupper((new \ReflectionClass($this))->getShortName()) . '_';
        $env = new \UUA\ArrayObjectStrict($this->container->get('env'));

        switch ($env[$prefix . 'DRIVER']) {
            case 'pdo_sqlite':
                $params = [
                    'path' => sprintf('%s/%s', $this->container->get('basePath'), $env[$prefix . 'PATH']),
                    'driver' => $env[$prefix . 'DRIVER'],
                    'charset' => 'UTF8',
                ];
                break;
            case 'pdo_pgsql':
            case 'pdo_mysql':
                $params = [
                    'dbname' => $env[$prefix . 'DBNAME'],
                    'user' => $env[$prefix . 'USER'],
                    'password' => $env[$prefix . 'PASSWORD'],
                    'host' => $env[$prefix . 'HOST'],
                    'driver' => $env[$prefix . 'DRIVER'],
                    'charset' => 'UTF8',
                ];
                break;
            default:
                throw new \RuntimeException(sprintf('driver %s not supported', $env[$prefix . 'DRIVER']));
        }

        return $this->connection = DriverManager::getConnection($params);
    }
}
