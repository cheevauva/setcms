<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Module\Module01\Entity01Entity;

class Entity01RetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use Entity01GenericDAO;

    public Entity01Entity $Entity01LC;

    public function serve(): void
    {
        parent::serve();

        $this->Entity01LC = $this->entity;
    }

}
