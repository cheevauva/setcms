<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use SetCMS\Servant\EntityCreateServant;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostHasByIdDAO;
use Module\Post\DAO\PostCreateDAO;

/**
 * @extends EntityCreateServant<PostEntity>
 */
class PostCreateServant extends EntityCreateServant
{

    protected string $clsHasById = PostHasByIdDAO::class;
    protected string $clsCreate = PostCreateDAO::class;
}
