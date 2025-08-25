<?php

declare(strict_types=1);

namespace SetCMS\Database;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
use SetCMS\Database\Database;
use SensitiveParameter;

class DatabaseDriverManager
{

    /**
     * @param array<string, mixed> $params
     * @param Configuration|null $config
     * @return Database
     * @throws \Exception
     */
    public static function getConnection(#[SensitiveParameter] array $params, ?Configuration $config = null): Database
    {
        $connection = DriverManager::getConnection($params, $config);

        if (!$connection instanceof Database) {
            throw new \Exception(sprintf('Ожидался инстанс класса (или наследника) %s, а пришел %s', Database::class, $connection::class));
        }

        return $connection;
    }
}
