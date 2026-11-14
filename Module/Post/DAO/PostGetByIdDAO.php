<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use SetCMS\Entity\Servant\EntityGetByIdServant;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;

/**
 * @extends EntityGetByIdServant<PostEntity>
 */
class PostGetByIdDAO extends EntityGetByIdServant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    #[\Override]
    protected function manyByCriteria(): PostRetrieveManyByCriteriaDAO
    {
        return PostRetrieveManyByCriteriaDAO::new($this);
    }
}
