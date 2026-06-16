<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageGetBySlugDAO;
use Module\Page\View\PagePublicReadBlockView;
use Module\Page\Mapper\PageSlugFromRequest;

class PagePublicReadBlockBySlugController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected string $slug;
    protected PageEntity $page;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageSlugFromRequest::class,
            PageGetBySlugDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePublicReadBlockView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageGetBySlugDAO) {
            $object->slug = $this->slug;
        }

        if ($object instanceof PagePublicReadBlockView) {
            $object->page = $this->page;
            $object->slug = $this->slug;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageGetBySlugDAO) {
            $this->page = $object->page;
        }

        if ($object instanceof PageSlugFromRequest) {
            $this->slug = $object->slug;
        }
    }
}
