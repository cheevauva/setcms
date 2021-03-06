<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

abstract class EntityDbRetrieveByIdDAO extends EntityDbRetrieveByCriteriaDAO
{

    public string $id;
    public bool $deleted = false;

    public function serve(): void
    {
        $this->criteria = [
            'id' => $this->id,
            'deleted' => (int) $this->deleted,
        ];

        parent::serve();
    }

}
