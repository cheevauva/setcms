<?php

declare(strict_types=1);

namespace Module\Module01\Servant;

use SetCMS\Servant\EntityDeleteServant;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01RetrieveManyByCriteriaDAO;
use Module\Module01\DAO\Entity01DeleteByIdDAO;
use Module\Module01\DAO\Entity01UpdateDAO;

/**
 * @extends EntityDeleteServant<Entity01Entity>
 */
class Entity01DeleteServant extends EntityDeleteServant
{

    protected string $clsRetrieve = Entity01RetrieveManyByCriteriaDAO::class;
    protected string $clsUpdate = Entity01UpdateDAO::class;
    protected string $clsDelete = Entity01DeleteByIdDAO::class;
}
