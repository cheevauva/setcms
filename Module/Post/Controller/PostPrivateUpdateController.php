<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use Module\Post\Servant\PostUpdateServant;
use Module\Post\View\PostPrivateUpdateView;
use Module\Post\Exception\PostNotFoundException;

class PostPrivateUpdateController extends ControllerViaPSR7
{

    protected PostEntity $entity;
    protected PostEntity $newEntity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostRetrieveManyByCriteriaDAO::class,
            PostUpdateServant::class,
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
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newEntity = new PostEntity;
        $this->newEntity->id = $validation->uuid('entity.id')->notEmpty()->val();
        $this->newEntity->slug = $validation->string('entity.slug')->notEmpty()->val();
        $this->newEntity->title = $validation->string('entity.title')->notEmpty()->val();
        $this->newEntity->message = $validation->string('entity.message')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $object->id = $this->newEntity->id;
            $object->limit = 1;
        }

        if ($object instanceof PostUpdateServant) {
            $object->entity = $this->entity;
        }

        if ($object instanceof PostPrivateUpdateView) {
            $object->entity = $this->entity ?? null;
        }
    }
    
    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->entity = $object->first ?? throw new PostNotFoundException();
            $this->entity->slug = $this->newEntity->slug;
            $this->entity->title = $this->newEntity->title;
            $this->entity->message = $this->newEntity->message;
        }
    }
}
