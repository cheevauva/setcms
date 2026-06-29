<?php

declare(strict_types=1);

namespace Module\Email\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Email\Entity\EmailEntity;
use Module\Email\DAO\EmailRetrieveManyByCriteriaDAO;
use Module\Email\View\EmailPrivateReadView;
use SetCMS\Request\Mapper\RequestToIdMapper;

class EmailPrivateReadController extends ControllerViaPSR7
{

    protected EmailEntity $email;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RequestToIdMapper::class,
            EmailRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            EmailPrivateReadView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof EmailRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->expectOne = true;
            $object->limit = 1;
            $object->allowEmptyResult = false;
        }

        if ($object instanceof EmailPrivateReadView) {
            $object->email = $this->email;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof EmailRetrieveManyByCriteriaDAO) {
            $this->email = $object->email;
        }

        if ($object instanceof RequestToIdMapper) {
            $this->id = $object->id;
        }
    }
}
