<?php

declare(strict_types=1);

namespace Module\Module01\Servant;

use SetCMS\Servant\EntityCreateServant;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01HasByIdDAO;
use Module\Module01\DAO\Entity01CreateDAO;

/**
 * @extends EntityCreateServant<Entity01Entity>
 */
class Entity01CreateServant extends EntityCreateServant
{

    protected string $clsHasById = Entity01HasByIdDAO::class;
    protected string $clsCreate = Entity01CreateDAO::class;
}
