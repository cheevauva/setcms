<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\DAO;

use SetCMS\Common\DAO\EntityRetrieveByIdDAO;
use SetCMS\Module\Module01\Entity\Entity01Entity;

class Entity01RetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use Entity01CommonDAO;

    public Entity01Entity $Entity01LC;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->Entity01LC = $this->entity;
    }
}
