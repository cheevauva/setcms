<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use SetCMS\DAO\EntityRetrieveManyDAO;
use Module\Module01\Mapper\Entity01FromRowMapper;
use Module\Module01\Entity\Entity01Entity;

/**
 * @extends EntityRetrieveManyDAO<Entity01Entity, Entity01FromRowMapper>
 */
class Entity01RetrieveManyByCriteriaDAO extends EntityRetrieveManyDAO
{

    use Entity01CommonDAO;

    protected string $clsMapper = Entity01FromRowMapper::class;
}
