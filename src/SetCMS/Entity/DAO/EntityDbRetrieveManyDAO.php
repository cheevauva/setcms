<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

abstract class EntityDbRetrieveManyDAO extends EntityDbDAO implements \SetCMS\ServantInterface
{

    public ?\Iterator $rows = null;
    public ?\Iterator $entities = null;

    public function serve(): void
    {
        $qb = $this->createQuery();

        $this->rows = $qb->executeQuery()->iterateAssociative();
        $this->entities = $this->prepareEntitiesByRows($this->rows);
    }

    protected function prepareEntitiesByRows(\Iterator $rows): \Iterator
    {
        if (!$rows->valid()) {
            yield from [];
            return;
        }

        foreach ($rows as $row) {
            yield $this->entity4row($row);
        }
    }

}
