<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use SetCMS\DAO\EntityCreateDAO;
use Module\Post\Entity\PostEntity;
use Module\Post\Mapper\PostToRowMapper;

/**
 * @extends EntityCreateDAO<PostEntity, PostToRowMapper>
 */
class PostCreateDAO extends EntityCreateDAO
{

    use PostCommonDAO;

    protected string $clsMapper = PostToRowMapper::class;
}
