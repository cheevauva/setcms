<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Email\Entity\EmailEntity;
use SetCMS\Module\Email\Servant\EmailCreateServant;
use SetCMS\Module\Email\View\EmailPrivateCreateView;

class EmailPrivateCreateController extends ControllerViaPSR7
{

    protected EmailEntity $email;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            EmailCreateServant::class,
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
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('email')->notEmpty()->validate();

        $this->email = new EmailEntity();
        $this->email->id = $validation->uuid('email.id')->val();
        $this->email->subject = $validation->string('email.subject')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof EmailCreateServant) {
            $object->email = $this->email;
        }

        if ($object instanceof EmailPrivateCreateView) {
            $object->email = $this->email;
        }
    }
}
