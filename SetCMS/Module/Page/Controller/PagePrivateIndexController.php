<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveManyByCriteriaDAO;
use SetCMS\Module\Page\View\PagePrivateIndexView;

class PagePrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var PageEntity[]
     */
    protected array $pages = [];
    
    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageRetrieveManyByCriteriaDAO::class,
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

        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $this->pages = $object->pages;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PagePrivateIndexView) {
            $object->pages = $this->pages;
        }
    }
}
