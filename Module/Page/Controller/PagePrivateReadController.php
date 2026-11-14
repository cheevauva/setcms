<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Page\Entity\PageEntity;
use Module\Page\Servant\PageGetByIdServant;
use Module\Page\View\PagePrivateReadView;
use SetCMS\Request\Mapper\RequestToIdMapper;

class PagePrivateReadController extends ControllerViaPSR7
{

    protected PageEntity $entity;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RequestToIdMapper::class,
            PageGetByIdServant::class,
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
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageGetByIdServant) {
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

        if ($object instanceof PageGetByIdServant) {
            $this->entity = $object->entity;
        }
        
        if ($object instanceof RequestToIdMapper) {
            $this->id = $object->id;
        }
    }
}
