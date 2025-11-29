<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use SetCMS\DAO\EntityCreateDAO;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Mapper\Entity01ToRowMapper;

/**
 * @extends EntityCreateDAO<Entity01Entity, Entity01ToRowMapper>
 */
class Entity01CreateDAO extends EntityCreateDAO
{

    use Entity01CommonDAO;

    #[\Override]
    protected function mapper(): Entity01ToRowMapper
    {
        return Entity01ToRowMapper::new($this->container);
    }
}
