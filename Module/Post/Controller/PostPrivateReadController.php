<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostGetByIdDAO;
use Module\Post\View\PostPrivateReadView;
use SetCMS\Request\Mapper\RequestToIdMapper;

class PostPrivateReadController extends ControllerViaPSR7
{

    protected PostEntity $entity;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RequestToIdMapper::class,
            PostGetByIdDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPrivateReadView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostGetByIdDAO) {
            $object->id = $this->id;
        }

        if ($object instanceof PostPrivateReadView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostGetByIdDAO) {
            $this->entity = $object->entity;
        }

        if ($object instanceof RequestToIdMapper) {
            $this->id = $object->id;
        }
    }
}
