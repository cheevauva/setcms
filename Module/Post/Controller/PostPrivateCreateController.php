<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostCreateDAO;
use Module\Post\View\PostPrivateCreateView;
use Module\Post\Mapper\PostFromRequestMapper;

class PostPrivateCreateController extends ControllerViaPSR7
{

    protected PostEntity $entity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostFromRequestMapper::class,
            PostCreateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPrivateCreateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostCreateDAO) {
            $object->entity = $this->entity;
        }

        if ($object instanceof PostPrivateCreateView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostFromRequestMapper) {
            $this->entity = $object->entity;
        }
    }
}
