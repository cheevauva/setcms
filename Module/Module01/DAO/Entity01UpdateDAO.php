<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use SetCMS\DAO\EntityUpdateDAO;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Mapper\Entity01ToRowMapper;

/**
 * @extends EntityUpdateDAO<Entity01Entity>
 */
class Entity01UpdateDAO extends EntityUpdateDAO
{

    use Entity01CommonDAO;

    protected string $clsMapper = Entity01ToRowMapper::class;
}
