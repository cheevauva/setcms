<?php

declare(strict_types=1);

namespace Module\Template\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;
use Module\Template\Entity\TemplateEntity;
use Module\Template\Mapper\TemplateFromRowMapper;

/**
 * @extends EntityRetrieveByCriteriaDAO<TemplateEntity>
 */
class TemplateRetrieveManyByCriteriaDAO extends EntityRetrieveByCriteriaDAO
{

    use \Module\Template\Traits\TemplateDbalDAOTrait;

    public string $slug;

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
    protected function rowToEntity(array $row): TemplateEntity
    {
        return TemplateFromRowMapper::call($this, $row)->entity;
    }
}
