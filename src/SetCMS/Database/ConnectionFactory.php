<?php

namespace SetCMS\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseExeption;

class ConnectionFactory
{

    private array $connections = [];
    private string $basePath;

    public function __construct(ContainerInterface $container)
    {
        $this->connectionsMetadata = $container->get('connections');
        $this->basePath = $container->get('basePath');
    }

    public function get(string $connection): Connection
    {
        if (!isset($this->connectionsMetadata[$connection])) {
            throw DatabaseExeption::notFound($connection);
        }
        
        if (empty($this->connections[$connection])) {
            $metadata = $this->connectionsMetadata[$connection];

            foreach ($metadata as $index => $value) {
                $metadata[$index] = str_replace(':basePath', $this->basePath, $value);
            }

            $this->connections[$connection] = DriverManager::getConnection($metadata);
        }

        return $this->connections[$connection];
    }

}
