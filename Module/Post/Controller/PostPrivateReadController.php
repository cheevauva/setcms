<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostGetByIdDAO;
use Module\Post\View\PostPrivateReadView;
use SetCMS\Mapper\MapperIdFromRequest;

class PostPrivateReadController extends ControllerViaPSR7
{

    protected PostEntity $post;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MapperIdFromRequest::class,
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
            $object->post = $this->post;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostGetByIdDAO) {
            $this->post = $object->post;
        }

        if ($object instanceof MapperIdFromRequest) {
            $this->id = $object->id;
        }
    }
}
