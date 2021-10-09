<?php

namespace SetCMS\Module\Migrations;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\Migrations\MigrationException;
use SetCMS\Module\Migrations\Migration;
use SetCMS\Database\Migration as MigrationUnit;

class MigrationDAO extends OrdinaryDAO
{

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        assert($entity instanceof Migration);

        return $this->ordinaryEntity2RecordBind($entity, [
            'migration' => $entity->migration,
        ]);
    }

    protected function getException(): \Exception
    {
        return new MigrationException;
    }

    protected function getTableName(): string
    {
        return 'migrations';
    }

    protected function record2entity(array $record): \SetCMS\Module\Ordinary\OrdinaryEntity
    {
        $entity = new Migration;
        $entity->migration = $record['migration'];

        return $this->ordinaryRecord2EntityBind($record, $entity);
    }
    
    public function getExecuted(): array
    {
        $schemeManager = $this->dbal()->createSchemaManager();
        
        if (!$schemeManager->tablesExist($this->getTableName())) {
            return [];
        }
        
        $qb = $this->dbal()->createQueryBuilder();
        $qb->select('t.migration');
        $qb->from($this->getTableName(), 't');
        
        return array_column($qb->fetchAllAssociative(), 'migration');
    }

    public function getAll(): array
    {
        $files = glob(str_replace('.php', '/*.php', (new \ReflectionClass(MigrationUnit::class))->getFileName()));
        $migrations = [];
        
        foreach ($files as $file) {
            $migrations[] = MigrationUnit::class . '\\' . str_replace('.php', '', basename($file));
        }
        
        sort($migrations, SORT_STRING);
        
        return $migrations;
    }

}
