<?php

declare(strict_types=1);

namespace Module\Post\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\Basic\DAO\BasicEntityRetrieveByCriteriaDAO;
use Module\Post\Entity\PostEntity;
use Module\Post\Mapper\PostFromRowMapper;

/**
 * @extends BasicEntityRetrieveByCriteriaDAO<PostEntity>
 */
class PostRetrieveManyByCriteriaDAO extends BasicEntityRetrieveByCriteriaDAO
{

    use \Module\Post\Traits\PostDbalDAOTrait;

    public string $slug;

    #[\Override]
    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = parent::createQb();

        if (isset($this->slug)) {
            $qb->andWhere('slug = :slug');
            $qb->setParameter('slug', $this->slug);
        }

        return $qb;
    }



    #[\Override]
    protected function rowToEntity(array $row): PostEntity
    {
        return PostFromRowMapper::call($this->container, $row)->entity;
    }
}
