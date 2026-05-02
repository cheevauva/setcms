<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageGetBySlugDAO;
use Module\Page\View\PagePublicReadView;

class PagePublicReadBySlugController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected string $slug;
    protected PageEntity $page;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
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
    protected function fromRequest(): void
    {
        $this->slug = $this->validationParams()->string('slug')->notEmpty()->notQuiet()->val();
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
    }
}
