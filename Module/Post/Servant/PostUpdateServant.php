<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use SetCMS\Servant\EntityUpdateServant;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostHasByIdDAO;
use Module\Post\DAO\PostUpdateDAO;

/**
 * @extends EntityUpdateServant<PostEntity>
 */
class PostUpdateServant extends EntityUpdateServant
{

    protected string $clsHasById = PostHasByIdDAO::class;
    protected string $clsUpdate = PostUpdateDAO::class;
}
