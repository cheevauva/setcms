<?php

declare(strict_types=1);

namespace Module\Module01\Servant;

use SetCMS\Servant\EntityUpdateServant;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01HasByIdDAO;
use Module\Module01\DAO\Entity01UpdateDAO;

/**
 * @extends EntityUpdateServant<Entity01Entity>
 */
class Entity01UpdateServant extends EntityUpdateServant
{
    protected string $clsHasById = Entity01HasByIdDAO::class;
    protected string $clsUpdate = Entity01UpdateDAO::class;
}
