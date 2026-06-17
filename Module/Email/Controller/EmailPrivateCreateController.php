<?php

declare(strict_types=1);

namespace Module\Email\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Email\Entity\EmailEntity;
use Module\Email\DAO\EmailCreateDAO;
use Module\Email\View\EmailPrivateCreateView;
use Module\Email\Mapper\EmailFromRequestMapper;

class EmailPrivateCreateController extends ControllerViaPSR7
{

    protected EmailEntity $email;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            EmailFromRequestMapper::class,
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

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof EmailFromRequestMapper) {
            $this->email = $object->email;
        }
    }
}
