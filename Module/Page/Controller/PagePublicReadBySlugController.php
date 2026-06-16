<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageGetBySlugDAO;
use Module\Page\View\PagePublicReadView;
use Module\Page\Mapper\PageSlugFromRequest;

class PagePublicReadBySlugController extends \SetCMS\Controller\ControllerViaPSR7
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
            PagePublicReadView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageGetBySlugDAO) {
            $object->slug = $this->slug;
        }

        if ($object instanceof PagePublicReadView) {
            $object->page = $this->page;
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
