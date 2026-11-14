<?php

declare(strict_types=1);

namespace Module\Email\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Email\Entity\EmailEntity;
use Module\Email\DAO\EmailRetrieveManyByCriteriaDAO;
use Module\Email\DAO\EmailUpdateDAO;
use Module\Email\View\EmailPrivateUpdateView;
use Module\Email\Mapper\EmailFromRequestMapper;

class EmailPrivateUpdateController extends ControllerViaPSR7
{

    protected EmailEntity $entity;
    protected EmailEntity $newEntity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            EmailFromRequestMapper::class,
            EmailRetrieveManyByCriteriaDAO::class,
            EmailUpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            EmailPrivateUpdateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof EmailRetrieveManyByCriteriaDAO) {
            $object->id = $this->newEntity->id;
            $object->expectOne = true;
            $object->allowEmptyResult = false;
            $object->limit = 1;
        }

        if ($object instanceof EmailUpdateDAO) {
            $object->entity = $this->entity;
            $object->entity->subject = $this->newEntity->subject;
        }

        if ($object instanceof EmailPrivateUpdateView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof EmailRetrieveManyByCriteriaDAO) {
            $this->entity = $object->entity;
        }

        if ($object instanceof EmailFromRequestMapper) {
            $this->newEntity = $object->entity;
        }
    }
}
