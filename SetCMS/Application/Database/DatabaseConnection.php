<?php

declare(strict_types=1);

namespace SetCMS\Application\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

abstract class DatabaseConnection implements \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\EnvTrait;

    protected Connection $connection;

    public function getConnection(): Connection
    {
        if (isset($this->connection)) {
            return $this->connection;
        }

        $prefix = mb_strtoupper((new \ReflectionClass($this))->getShortName()) . '_';
        $env = $this->env();
        $driver = strval($env[$prefix . 'DRIVER']);

        switch ($driver) {
            case 'pdo_sqlite':
                $params = [
                    'path' => $env[$prefix . 'PATH'],
                    'driver' => $driver,
                    'charset' => 'UTF8',
                ];
                break;
            case 'pdo_pgsql':
            case 'pdo_mysql':
                $params = [
                    'dbname' => strval($env[$prefix . 'DBNAME']),
                    'user' => strval($env[$prefix . 'USER']),
                    'password' => strval($env[$prefix . 'PASSWORD']),
                    'host' => strval($env[$prefix . 'HOST']),
                    'driver' => $driver,
                    'charset' => 'UTF8',
                ];
                break;
            default:
                throw new \RuntimeException(sprintf('driver %s not supported', $env[$prefix . 'DRIVER']));
        }

        return $this->connection = DriverManager::getConnection($params);
    }

}
