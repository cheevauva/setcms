<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\Page\Mapper\PageFromRowMapper;
use Module\Page\Entity\PageEntity;
use Module\Basic\DAO\BasicEntityRetrieveByCriteriaDAO;

/**
 * @extends BasicEntityRetrieveByCriteriaDAO<PageEntity>
 */
class PageRetrieveByCriteriaDAO extends BasicEntityRetrieveByCriteriaDAO
{

    use \Module\Page\Traits\PageDbalDAOTrait;

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
    protected function rowToEntity(array $row): PageEntity
    {
        return PageFromRowMapper::call($this, $row)->entity;
    }
}
