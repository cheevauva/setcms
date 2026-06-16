<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Page\Entity\PageEntity;
use Module\Page\Servant\PageGetByIdServant;
use Module\Page\DAO\PageUpdateDAO;
use Module\Page\View\PagePrivateUpdateView;
use Module\Page\Mapper\PageFromRequestMapper;

class PagePrivateUpdateController extends ControllerViaPSR7
{

    public PageEntity $page;
    public PageEntity $newPage;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageFromRequestMapper::class,
            PageGetByIdServant::class,
            PageUpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePrivateUpdateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageGetByIdServant) {
            $object->id = $this->newPage->id;
        }

        if ($object instanceof PageUpdateDAO) {
            $object->page = $this->page;
            $object->page->slug = $this->newPage->slug;
            $object->page->title = $this->newPage->title;
            $object->page->content = $this->newPage->content;
        }

        if ($object instanceof PagePrivateUpdateView) {
            $object->entity = $this->page;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageGetByIdServant) {
            $this->page = $object->page;
        }

        if ($object instanceof PageFromRequestMapper) {
            $this->newPage = $object->page;
        }
    }
}
