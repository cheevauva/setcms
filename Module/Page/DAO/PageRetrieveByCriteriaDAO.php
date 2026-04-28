<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\Page\Mapper\PageFromRowMapper;
use Module\Page\Entity\PageEntity;
use Module\Page\Exception\PageNotFoundException;
use Module\Page\Exception\PageEntitiesNotFoundException;
use Module\Page\Exception\PageEntityExpectOneButReceivedTooMuchException;

class PageRetrieveByCriteriaDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityRetrieveByCriteriaTrait;
    use \Module\Page\Traits\PageDbalDAOTrait;

    /**
     * @var array<PageEntity>
     */
    public protected(set) array $pages = [];
    public protected(set) PageEntity $page;
    public protected(set) ?PageEntity $pageOrNull = null;
    public string $slug;
    public bool $deleted = false;

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->pages = array_map(fn($row) => PageFromRowMapper::call($this->container, $row)->page, $rows);
        $this->pages ? $this->page = $this->pageOrNull = $this->pages[0] : null;
    }

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
        return new PageEntitiesNotFoundException;
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new PageEntityExpectOneButReceivedTooMuchException;
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new PageNotFoundException;
    }
}
