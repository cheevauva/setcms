<?php

declare(strict_types=1);

namespace Module\Menu\DAO;

use Module\Menu\Entity\MenuEntity;
use Module\Menu\Mapper\MenuFromRowMapper;
use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;

/**
 * @extends EntityRetrieveByCriteriaDAO<MenuEntity>
 */
class MenuRetrieveManyByCriteriaDAO extends EntityRetrieveByCriteriaDAO
{

    use \Module\Menu\Traits\MenuDbalDAOTrait;

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
    protected function rowToEntity(array $row): MenuEntity
    {
        return MenuFromRowMapper::call($this, $row)->entity;
    }
}
