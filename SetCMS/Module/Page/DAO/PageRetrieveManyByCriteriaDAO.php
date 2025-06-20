<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Module\Page\PageEntity;
use Doctrine\DBAL\Query\QueryBuilder;
use SetCMS\Module\Page\Exception\PageNotFoundException;

class PageRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use PageCommonDAO;

    public string $slug;

    /**
     * @var PageEntity[]
     */
    public array $pages;
    public ?PageEntity $page;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->pages = PageEntity::manyAs($this->entities);
        $this->page = $this->first ? PageEntity::as($this->first) : null;
    }

    #[\Override]
    protected function createQuery(): QueryBuilder
    {
        $qb = parent::createQuery();

        if (isset($this->slug)) {
            $qb->andWhere('slug = :slug');
            $qb->setParameter('slug', $this->slug);
        }

        return $qb;
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new PageNotFoundException();
    }
}
