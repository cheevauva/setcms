<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\DAO;

use SetCMS\Common\DAO\Entity\EntitySaveDAO;
use SetCMS\Module\Module01\Entity\Entity01Entity;

class Entity01SaveDAO extends EntitySaveDAO
{

    use Entity01GenericDAO;

    public Entity01Entity $Entity01LC;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->Entity01LC;

        parent::serve();
    }
}
