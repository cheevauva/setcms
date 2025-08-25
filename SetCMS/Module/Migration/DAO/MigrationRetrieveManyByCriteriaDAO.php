<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\DAO;

use SetCMS\Database\Database;
use SetCMS\Module\Migration\Exception\MigrationNotFoundException;
use SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO;
use SetCMS\Module\Migration\Entity\MigrationEntity;

class MigrationRetrieveManyByCriteriaDAO extends EntityRetrieveManyByCriteriaDAO
{

    use MigrationCommonDAO;

    public Database $db;
    public ?int $limit = null;

    /**
     * @var array<string, MigrationEntity>
     */
    public array $migrations;

    #[\Override]
    public function serve(): void
    {
        $this->migrations = [];

        if (!$this->db()->createSchemaManager()->tableExists($this->table())) {
            return;
        }

        parent::serve();

        foreach ($this->entities as $entity) {
            $migration = MigrationEntity::as($entity);

            $this->migrations[$migration->version] = $migration;
        }
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        throw new MigrationNotFoundException();
    }
}
