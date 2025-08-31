<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Module\Migration\Entity\MigrationEntity;

class MigrationSaveDAO extends \SetCMS\Common\DAO\EntitySaveDAO
{

    use MigrationCommonDAO;

    public MigrationEntity $migration;

    protected function has(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->select('version');
        $qb->from($this->table());
        $qb->andWhere('version = :version');
        $qb->setParameter('version', $this->migration->version);
        $qb->setMaxResults(1);

        return $qb;
    }

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->migration;

        parent::serve();
    }
}
