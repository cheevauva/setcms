<?php

declare(strict_types=1);

namespace SetCMS\Database\Connection;

use Psr\Container\ContainerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

abstract class Database extends Connection
{

    public function __construct(ContainerInterface $container)
    {
        $basePath = $container->get('basePath');
        $prefix = mb_strtoupper((new \ReflectionClass($this))->getShortName());
        $env = $this->env($container->get('env'), $prefix);

        switch ($env->get('DRIVER')) {
            case 'pdo_sqlite':
                $params = [
                    'path' => sprintf('%s/%s', $basePath, $env->get('PATH')),
                    'driver' => $env->get('DRIVER'),
                    'charset' => 'UTF8',
                ];
                break;
            case 'pdo_pgsql':
            case 'pdo_mysql':
                $params = [
                    'dbname' => $env->get('DBNAME'),
                    'user' => $env->get('USER'),
                    'password' => $env->get('PASSWORD'),
                    'host' => $env->get('HOST'),
                    'driver' => $env->get('DRIVER'),
                    'charset' => 'UTF8',
                ];
                break;
        }

        $createDriverMethod = (new \ReflectionClass(DriverManager::class))->getMethod('createDriver');
        $createDriverMethod->setAccessible(true);

        return parent::__construct($params, $createDriverMethod->invoke(null, $params));
    }

    private function env(array $env, string $prefix)
    {
        return new class($env, $prefix) {

            protected array $env;
            protected string $prefix;

            public function __construct(array $env, string $prefix)
            {
                $this->prefix = $prefix;
                $this->env = $env;
            }

            public function get(string $name): string
            {
                if (!isset($this->env[$this->prefix . '_' . $name])) {
                    throw new \RuntimeException(sprintf('%s not defined in env', $this->prefix . '_' . $name));
                }

                return $this->env[$this->prefix . '_' . $name];
            }
        };
    }

}
