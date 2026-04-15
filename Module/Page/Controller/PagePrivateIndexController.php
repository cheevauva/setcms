<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Page\DAO\PageRetrieveByCriteriaDAO;
use Module\Page\View\PagePrivateIndexView;
use Module\Page\Entity\PageEntity;

class PagePrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var PageEntity[]
     */
    protected array $entities = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageRetrieveByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageRetrieveByCriteriaDAO) {
            $this->entities = $object->pages;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof PagePrivateIndexView) {
            $object->entities = $this->entities;
        }
    }
}
