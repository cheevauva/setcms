<?php

declare(strict_types=1);

namespace SetCMS\Core\Entity\DAO;

class EntityRetrieveByIdDAO extends EntityRetrieveByCriteriaDAO
{

    public string $id;
    public bool $deleted = 0;

    public function serve(): void
    {
        $this->criteria = [
            'id' => $this->id,
            'deleted' => $this->deleted,
        ];

        parent::serve();
    }

}
