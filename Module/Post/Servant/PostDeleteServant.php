<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use SetCMS\Servant\EntityDeleteServant;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use Module\Post\DAO\PostDeleteByIdDAO;
use Module\Post\DAO\PostUpdateDAO;

/**
 * @extends EntityDeleteServant<PostEntity>
 */
class PostDeleteServant extends EntityDeleteServant
{

    protected string $clsRetrieve = PostRetrieveManyByCriteriaDAO::class;
    protected string $clsUpdate = PostUpdateDAO::class;
    protected string $clsDelete = PostDeleteByIdDAO::class;
}
