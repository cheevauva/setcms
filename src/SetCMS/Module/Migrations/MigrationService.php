<?php

namespace SetCMS\Module\Migrations;

use SetCMS\Module\Migrations\MigrationDAO;
use SetCMS\Database\Migration as MigrationUnit;
use SetCMS\Module\Migrations\Migration;
use Psr\Container\ContainerInterface;
use SetCMS\Module\Ordinary\OrdinaryService;

class MigrationService extends OrdinaryService
{

    private MigrationDAO $migrationDAO;
    private ContainerInterface $container;

    public function __construct(MigrationDAO $migrationDAO, ContainerInterface $container)
    {
        $this->migrationDAO = $migrationDAO;
        $this->container = $container;
    }

    public function addByMigrationObject(MigrationUnit $migrationObject): Migration
    {
        $migration = new Migration;
        $migration->migration = get_class($migrationObject);

        $this->migrationDAO->save($migration);

        return $migration;
    }

    public function migrate(): void
    {
        $migrations = array_flip($this->migrationDAO->getAll());
        $executedMigrations = $this->migrationDAO->getExecuted();

        foreach ($executedMigrations as $executedMigration) {
            unset($migrations[$executedMigration]);
        }

        foreach (array_flip($migrations) as $migration) {
            $migrationClass = $migration;
            $migrationUnit = $this->container->get($migrationClass);

            assert($migrationUnit instanceof MigrationUnit);

            try {
                $migrationUnit->up();
                $this->addByMigrationObject($migrationUnit);
            } catch (Exception $ex) {
                
            }
        }
    }

    protected function dao(): MigrationDAO
    {
        return $this->migrationDAO;
    }

    public function entity(): Migration
    {
        return new Migration;
    }

}
