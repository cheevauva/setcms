<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageCreateDAO;
use Module\Page\View\PagePrivateCreateView;
use Module\Page\Mapper\PageFromRequestMapper;

class PagePrivateCreateController extends ControllerViaPSR7
{

    private PageEntity $page;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageFromRequestMapper::class,
            PageCreateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePrivateCreateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageCreateDAO) {
            $object->page = $this->page;
        }

        if ($object instanceof PagePrivateCreateView) {
            $object->entity = $this->page;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageFromRequestMapper) {
            $this->page = $object->page;
        }
    }
}
