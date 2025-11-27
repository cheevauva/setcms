<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use SetCMS\DAO\EntityUpdateDAO;
use Module\Post\Entity\PostEntity;
use Module\Post\Mapper\PostToRowMapper;

/**
 * @extends EntityUpdateDAO<PostEntity>
 */
class PostUpdateDAO extends EntityUpdateDAO
{

    use PostCommonDAO;

    protected string $clsMapper = PostToRowMapper::class;
}
