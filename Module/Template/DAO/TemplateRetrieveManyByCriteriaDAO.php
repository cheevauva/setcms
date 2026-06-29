<?php

declare(strict_types=1);

namespace Module\Template\DAO;

use Module\Template\Entity\TemplateEntity;
use Module\Template\Exception\TemplateNotFoundException;
use Module\Template\Mapper\TemplateFromRowMapper;
use SetCMS\Database\DatabaseQueryBuilder;

class TemplateRetrieveManyByCriteriaDAO extends \SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO
{

    use \Module\Template\Traits\TemplateDbalDAOTrait;

    /**
     * @var array<TemplateEntity>
     */
    public protected(set) array $templates;
    public protected(set) TemplateEntity $template;
    public protected(set) ?TemplateEntity $templateOrNull = null;
    public string $slug;

    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = $this->createQuery();

        if (isset($this->slug)) {
            $qb->andWhere('slug = :slug');
            $qb->setParameter('slug', $this->slug);
        }

        return $qb;
    }

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new TemplateNotFoundException();
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new TemplateNotFoundException();
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new TemplateNotFoundException();
    }

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->templates = array_map(fn($row) => TemplateFromRowMapper::call($this->container, $row)->template, $rows);
        $this->templates ? $this->template = $this->templateOrNull = $this->templates[0] : null;
    }
}
