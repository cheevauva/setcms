<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostGetByIdDAO;
use Module\Post\DAO\PostUpdateDAO;
use Module\Post\View\PostPrivateUpdateView;
use Module\Post\Mapper\PostFromRequestMapper;

class PostPrivateUpdateController extends ControllerViaPSR7
{

    protected PostEntity $entity;
    protected PostEntity $newEntity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostFromRequestMapper::class,
            PostGetByIdDAO::class,
            PostUpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPrivateUpdateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostGetByIdDAO) {
            $object->id = $this->newEntity->id;
        }

        if ($object instanceof PostUpdateDAO) {
            $object->entity = $this->entity;
            $object->entity->slug = $this->newEntity->slug;
            $object->entity->title = $this->newEntity->title;
            $object->entity->message = $this->newEntity->message;
        }

        if ($object instanceof PostPrivateUpdateView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof PostFromRequestMapper) {
            $this->newEntity = $object->entity;
        }
        
        if ($object instanceof PostGetByIdDAO) {
            $this->entity = $object->entity;
        }
    }
}
