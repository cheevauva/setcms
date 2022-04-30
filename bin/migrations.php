<?php

declare(strict_types=1);

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\Migrations\Tools\Console\Command;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Symfony\Component\Console\Application;

if (empty($directory) || empty($namespace) || empty($connection)) {
    echo "Один или несколько обязательных переменных не инициализированы\n";
    exit(1);
}

while (true) {
    assert($connection instanceof \Doctrine\DBAL\Connection);

    try {
        // ждем пока бд подниментся (на деве, на проде уже должно быть все подня)
        $connection->connect();
        break;
    } catch (Exception $ex) {
        sleep(1);
    }
}

if (!is_dir($directory)) {
    mkdir($directory);
}

$configuration = new Configuration($connection);
$configuration->addMigrationsDirectory($namespace, $directory);
$configuration->setAllOrNothing(true);
$configuration->setCheckDatabasePlatform(false);

$storageConfiguration = new TableMetadataStorageConfiguration();
$storageConfiguration->setTableName('migrations');

$configuration->setMetadataStorageConfiguration($storageConfiguration);

$dependencyFactory = DependencyFactory::fromConnection(new ExistingConfiguration($configuration), new ExistingConnection($connection));

$cli = new Application(sprintf('Doctrine Migrations %s', $namespace));
$cli->setCatchExceptions(true);
$cli->addCommands([
    new Command\DumpSchemaCommand($dependencyFactory),
    new Command\ExecuteCommand($dependencyFactory),
    new Command\GenerateCommand($dependencyFactory),
    new Command\LatestCommand($dependencyFactory),
    new Command\ListCommand($dependencyFactory),
    new Command\MigrateCommand($dependencyFactory),
    new Command\RollupCommand($dependencyFactory),
    new Command\StatusCommand($dependencyFactory),
    new Command\SyncMetadataCommand($dependencyFactory),
    new Command\VersionCommand($dependencyFactory),
]);
$cli->run();
