<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use Module\Post\View\PostPrivateReadView;
use Module\Post\Exception\PostNotFoundException;

class PostPrivateReadController extends ControllerViaPSR7
{

    protected PostEntity $entity;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostRetrieveManyByCriteriaDAO::class,
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
    protected function process(): void
    {
        $validation = $this->validation($this->params);

        $this->id = $validation->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->throwIfEmpty = new PostNotFoundException();
        }

        if ($object instanceof PostPrivateReadView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->entity = $object->first();
        }
    }
}
