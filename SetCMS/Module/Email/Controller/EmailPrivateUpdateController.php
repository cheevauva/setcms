<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Email\Entity\EmailEntity;
use SetCMS\Module\Email\DAO\EmailRetrieveManyByCriteriaDAO;
use SetCMS\Module\Email\Servant\EmailUpdateServant;
use SetCMS\Module\Email\View\EmailPrivateUpdateView;

class EmailPrivateUpdateController extends ControllerViaPSR7
{

    protected EmailEntity $email;
    protected EmailEntity $newemail;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            EmailRetrieveManyByCriteriaDAO::class,
            EmailUpdateServant::class,
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
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newemail = new EmailEntity;
        $this->newemail->id = $validation->uuid('email.id')->notEmpty()->val();
        $this->newemail->subject = $validation->string('email.subject')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof EmailRetrieveManyByCriteriaDAO) {
            $object->id = $this->newemail->id;
            $object->orThrow = true;
        }

        if ($object instanceof EmailUpdateServant) {
            $object->email = $this->email;
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
            $this->email = EmailEntity::as($object->email);
            $this->email->subject = $this->newemail->subject;
        }
    }
}
