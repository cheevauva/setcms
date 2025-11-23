<?php

declare(strict_types=1);

namespace Module\Module01\Servant;

use SetCMS\Servant\EntitySaveServant;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01HasByIdDAO;
use Module\Module01\DAO\Entity01CreateDAO;
use Module\Module01\DAO\Entity01UpdateDAO;

/**
 * @extends EntitySaveServant<Entity01Entity>
 */
class Entity01SaveServant extends EntitySaveServant
{

    public string $clsHas = Entity01HasByIdDAO::class;
    public string $clsUpdate = Entity01UpdateDAO::class;
    public string $clsCreate = Entity01CreateDAO::class;
}
