<?php

declare(strict_types=1);

namespace Module\Email\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Email\Entity\EmailEntity;
use Module\Email\DAO\EmailRetrieveManyByCriteriaDAO;
use Module\Email\View\EmailPrivateReadView;

class EmailPrivateReadController extends ControllerViaPSR7
{

    protected EmailEntity $email;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
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
    protected function process(): void
    {
        $validation = $this->validation($this->params);

        $this->id = $validation->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof EmailRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
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
            $this->email = EmailEntity::as($object->email);
        }
    }
}
