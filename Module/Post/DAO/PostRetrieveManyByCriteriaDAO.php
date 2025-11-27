<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use SetCMS\DAO\EntityRetrieveManyDAO;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Post\Mapper\PostFromRowMapper;
use Module\Post\Entity\PostEntity;

/**
 * @extends EntityRetrieveManyDAO<PostEntity, PostFromRowMapper>
 */
class PostRetrieveManyByCriteriaDAO extends EntityRetrieveManyDAO
{

    use PostCommonDAO;
    
    public string $slug;

    protected string $clsMapper = PostFromRowMapper::class;

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        if (isset($this->slug)) {
            $this->criteria['slug'] = $this->slug;
        }

        return parent::createQuery();
    }
}
