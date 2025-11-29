<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use SetCMS\DAO\EntityUpdateDAO;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Mapper\Entity01ToRowMapper;

/**
 * @extends EntityUpdateDAO<Entity01Entity, Entity01ToRowMapper>
 */
class Entity01UpdateDAO extends EntityUpdateDAO
{

    use Entity01CommonDAO;

    #[\Override]
    protected function mapper(): Entity01ToRowMapper
    {
        return Entity01ToRowMapper::new($this->container);
    }
}
