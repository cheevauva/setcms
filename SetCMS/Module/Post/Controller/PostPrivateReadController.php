<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\UUID;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Responder\ResponderBase;
use SetCMS\Module\Post\View\PostPrivateReadView;

class PostPrivateReadController extends PostPrivateController
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
            ResponderBase::class,
            PostPrivateReadView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        if ($this->request->getMethod() != 'GET') {
            throw new \Exception('GET');
        }

        $this->id = $this->validation($this->request->getAttributes())->uuid('id')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }

        if ($object instanceof PostPrivateReadView) {
            $object->post = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->entity = PostEntity::as($object->post);
        }
    }
}
