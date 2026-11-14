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

    public PageEntity $entity;
    public PageEntity $newEntity;

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
            $object->id = $this->newEntity->id;
        }

        if ($object instanceof PageUpdateDAO) {
            $object->entity = $this->entity;
            $object->entity->slug = $this->newEntity->slug;
            $object->entity->title = $this->newEntity->title;
            $object->entity->content = $this->newEntity->content;
        }

        if ($object instanceof PagePrivateUpdateView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageGetByIdServant) {
            $this->entity = $object->entity;
        }

        if ($object instanceof PageFromRequestMapper) {
            $this->newEntity = $object->entity;
        }
    }
}
