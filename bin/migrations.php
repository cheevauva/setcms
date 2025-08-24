<?php

declare(strict_types=1);

use Doctrine\DBAL\Driver\PDO\SQLite\Driver as SQLiteDriver;
use Doctrine\DBAL\Driver\PDO\MySQL\Driver as MysqlDriver;
use Doctrine\DBAL\Driver\PDO\PgSQL\Driver as PgSQLDriver;

if (empty($connection) || empty($name)) {
    echo "Один или несколько обязательных переменных не инициализированы\n";
    exit(1);
}

while (true) {
    assert($connection instanceof \Doctrine\DBAL\Connection);

    try {
        // ждем пока бд подниментся (на деве, на проде уже должно быть все подня)
        $connection->executeQuery('SELECT 1');
        break;
    } catch (Exception $ex) {
        sleep(1);
    }
}

if ($connection->getDriver() instanceof SQLiteDriver) {
    $type = 'sqlite';
}

if ($connection->getDriver() instanceof MysqlDriver) {
    $type = 'mysql';
}

if ($connection->getDriver() instanceof PgSQLDriver) {
    $type = 'pgsql';
}

$basePath = sprintf('resources/migrations/%s/%s/', $type, $name);

$connection->executeQuery(file_get_contents($basePath . 'u.migrations.sql'));

$migrations = $connection->fetchAllKeyValue('SELECT version, executed_at  FROM migrations ORDER BY version ASC');
$files = glob($basePath . 'u.*.*.sql');

switch ($argv[1] ?? null) {
    case 'down':
        
        break;
    case 'up':
        foreach ($files as $file) {
            $version = basename($file);

            if (isset($migrations[$version])) {
                continue;
            }

            $connection->beginTransaction();

            try {
                $start = microtime(true);
                
                $connection->executeQuery(file_get_contents($file));
                
                $qb = $connection->createQueryBuilder();
                $qb->insert('migrations');
                $qb->values([
                    'version' => ':version',
                    'executed_at' => ':executedAt',
                    'execution_time' => ':executionTime',
                ]);
                $qb->setParameters([
                    'version' => $version,
                    'executedAt' => gmdate('Y-m-d H:i:s'),
                    'executionTime' => intval(microtime(true) - $start),
                ]);
                $qb->executeQuery();

                $connection->commit();
                echo 'Done: ' . $file . "\n";
            } catch (Exception $ex) {
                $connection->rollBack();
                echo 'Failed (' . $file . '): ' . $ex->getMessage() . "\n";
            }
        }
        break;
    default:
        throw new \Exception($argv[1] . ' неизвестная команда');
}
