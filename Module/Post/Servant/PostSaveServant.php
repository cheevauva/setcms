<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use SetCMS\Servant\EntitySaveServant;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostHasByIdDAO;
use Module\Post\DAO\PostCreateDAO;
use Module\Post\DAO\PostUpdateDAO;

/**
 * @extends EntitySaveServant<PostEntity>
 */
class PostSaveServant extends EntitySaveServant
{

    public string $clsHas = PostHasByIdDAO::class;
    public string $clsUpdate = PostUpdateDAO::class;
    public string $clsCreate = PostCreateDAO::class;
}
