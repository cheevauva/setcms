<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use SetCMS\DAO\EntityUpdateDAO;
use Module\Post\Entity\PostEntity;
use Module\Post\Mapper\PostToRowMapper;

/**
 * @extends EntityUpdateDAO<PostEntity, PostToRowMapper>
 */
class PostUpdateDAO extends EntityUpdateDAO
{

    use PostCommonDAO;

    #[\Override]
    protected function mapper(): PostToRowMapper
    {
        return PostToRowMapper::new($this->container);
    }
}
