<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\Page\Mapper\PageFromRowMapper;
use Module\Page\Entity\PageEntity;
use Module\Page\Exception\PageNotFoundException;
use Module\Page\Exception\PagesNotFoundException;
use Module\Page\Exception\PageExpectOneButReceivedTooMuchException;

class PageRetrieveByCriteriaDAO extends \SetCMS\Entity\DAO\EntityBasicRetrieveByCriteriaDAO
{

    use \Module\Page\Traits\PageDbalDAOTrait;

    /**
     * @var array<PageEntity>
     */
    public protected(set) array $pages = [];
    public protected(set) PageEntity $page;
    public protected(set) ?PageEntity $pageOrNull = null;
    public string $slug;

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->pages = array_map(fn($row) => PageFromRowMapper::call($this->container, $row)->page, $rows);
        $this->pages ? $this->page = $this->pageOrNull = $this->pages[0] : null;
    }

    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = $this->createQuery();

        $this->basicQb($qb);

        if (isset($this->slug)) {
            $qb->andWhere('slug = :slug');
            $qb->setParameter('slug', $this->slug);
        }

        return $qb;
    }

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new PagesNotFoundException;
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new PageExpectOneButReceivedTooMuchException;
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new PageNotFoundException;
    }
}
