<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByIdDAO;

class Entity01RetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use Entity01GenericDAO;

    public Entity01Entity $Entity01LC;

    public function serve(): void
    {
        $this->entity = $this->Entity01LC;

        parent::serve();
    }

}
