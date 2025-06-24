<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\Servant;

use SetCMS\Module\Email\Entity\EmailEntity;
use SetCMS\Module\Email\DAO\EmailHasByIdDAO;
use SetCMS\Module\Email\DAO\EmailSaveDAO;
use SetCMS\Module\Email\Exception\EmailAlreadyExistsException;

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
