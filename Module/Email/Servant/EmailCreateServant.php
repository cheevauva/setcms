<?php

declare(strict_types=1);

namespace Module\Email\Servant;

use Module\Email\Entity\EmailEntity;
use Module\Email\DAO\EmailHasByIdDAO;
use Module\Email\DAO\EmailSaveDAO;
use Module\Email\Exception\EmailAlreadyExistsException;

class EmailCreateServant extends \UUA\Servant
{

    public EmailEntity $email;

    #[\Override]
    public function serve(): void
    {
        $hasEntityById = EmailHasByIdDAO::new($this->container);
        $hasEntityById->id = $this->email->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new EmailAlreadyExistsException;
        }

        $saveEntity = EmailSaveDAO::new($this->container);
        $saveEntity->email = $this->email;
        $saveEntity->serve();
    }
}
