<?php

declare(strict_types=1);

namespace Module\Email\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Email\Entity\EmailEntity;
use Module\Email\DAO\EmailCreateDAO;
use Module\Email\View\EmailPrivateCreateView;

class EmailPrivateCreateController extends ControllerViaPSR7
{

    protected EmailEntity $email;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            EmailCreateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            EmailPrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function fromRequest(): void
    {
        $body = $this->validationBody();
        $body->array('email')->notEmpty()->validate();

        $this->email = new EmailEntity();
        $this->email->id = $body->uuid('email.id')->val();
        $this->email->subject = $body->string('email.subject')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof EmailCreateDAO) {
            $object->email = $this->email;
        }

        if ($object instanceof EmailPrivateCreateView) {
            $object->email = $this->email;
        }
    }
}
