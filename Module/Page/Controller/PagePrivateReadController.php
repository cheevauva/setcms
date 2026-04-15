<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageGetByIdDAO;
use Module\Page\View\PagePrivateReadView;

class PagePrivateReadController extends ControllerViaPSR7
{

    protected PageEntity $entity;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageGetByIdDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePrivateReadView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->params);

        $this->id = $validation->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageGetByIdDAO) {
            $object->id = $this->id;
        }

        if ($object instanceof PagePrivateReadView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageGetByIdDAO) {
            $this->entity = $object->page;
        }
    }
}
