<?php

declare(strict_types=1);

namespace Module\Email\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Email\Entity\EmailEntity;
use Module\Email\DAO\EmailRetrieveManyByCriteriaDAO;
use Module\Email\DAO\EmailUpdateDAO;
use Module\Email\View\EmailPrivateUpdateView;

class EmailPrivateUpdateController extends ControllerViaPSR7
{

    protected EmailEntity $email;
    protected EmailEntity $newemail;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
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
    protected function fromRequest(): void
    {
        $body = $this->validationBody();

        $this->newemail = new EmailEntity;
        $this->newemail->id = $body->uuid('email.id')->notEmpty()->val();
        $this->newemail->subject = $body->string('email.subject')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof EmailRetrieveManyByCriteriaDAO) {
            $object->id = $this->newemail->id;
            $object->expectOne = true;
            $object->allowEmptyResult = false;
            $object->limit = 1;
        }

        if ($object instanceof EmailUpdateDAO) {
            $object->email = $this->email;
            $object->email->subject = $this->newemail->subject;
        }

        if ($object instanceof EmailPrivateUpdateView) {
            $object->email = $this->email ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof EmailRetrieveManyByCriteriaDAO) {
            $this->email = $object->email;
        }
    }
}
