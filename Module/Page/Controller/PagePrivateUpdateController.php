<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageRetrieveManyByCriteriaDAO;
use Module\Page\Servant\PageUpdateServant;
use Module\Page\View\PagePrivateUpdateView;
use Module\Page\Exception\PageNotFoundException;

class PagePrivateUpdateController extends ControllerViaPSR7
{

    protected PageEntity $entity;
    protected PageEntity $newEntity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageRetrieveManyByCriteriaDAO::class,
            PageUpdateServant::class,
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
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newEntity = new PageEntity;
        $this->newEntity->id = $validation->uuid('entity.id')->notEmpty()->val();
        $this->newEntity->slug = $validation->string('entity.slug')->notEmpty()->val();
        $this->newEntity->title = $validation->string('entity.title')->notEmpty()->val();
        $this->newEntity->content = $validation->string('entity.content')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $object->id = $this->newEntity->id;
            $object->limit = 1;
        }

        if ($object instanceof PageUpdateServant) {
            $object->entity = $this->entity;
        }

        if ($object instanceof PagePrivateUpdateView) {
            $object->entity = $this->entity ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $this->entity = $object->first ?? throw new PageNotFoundException();
            $this->entity->slug = $this->newEntity->slug;
            $this->entity->title = $this->newEntity->title;
            $this->entity->content = $this->newEntity->content;
        }
    }
}
