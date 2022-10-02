<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use SetCMS\UUID;

abstract class EntityDbRetrieveByIdDAO extends EntityDbRetrieveByCriteriaDAO
{

    public UUID $id;
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
